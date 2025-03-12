<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Clothes;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Menampilkan semua transaksi
    public function index()
    {
        // Ambil data transaksi dengan relasi details, clothes, dan size
        $transactions = Transaction::with(['details.clothes', 'details.size'])->paginate(10); // Sesuaikan jumlah pagination
        return view('transactions.index', compact('transactions'));
    }


    // Menampilkan form untuk membuat transaksi baru
    public function create()
    {
        $clothes = Clothes::all();
        $sizes = Size::all();
        return view('transactions.create', compact('clothes', 'sizes'));
    }

    // Menyimpan transaksi baru ke database
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'description' => 'nullable|string',
            'type' => 'required|in:in,out',
            'clothes_id' => 'required|array',
            'clothes_id.*' => 'exists:clothes,id',
            'size_id' => 'required|array',
            'size_id.*' => 'array', // Each clothes has an array of sizes
            'size_id.*.*' => 'exists:sizes,id', // Each size must be valid
            'quantity' => 'required|array',
            'quantity.*' => 'array', // Each clothes has an array of quantities
            'quantity.*.*' => 'integer|min:1', // Each quantity must be valid
            'custom_size' => 'nullable|array', // Custom size (optional)
            'custom_size.*' => 'nullable|array', // Each clothes has an array of custom sizes
            'custom_size.*.*' => 'nullable|string', // Each custom size must be string (if provided)
        ]);

        // Validate: Check for duplicate clothes in one transaction
        if (count($request->clothes_id) !== count(array_unique($request->clothes_id))) {
            return redirect()->back()->withErrors(['clothes_id' => 'Each clothes item can only be selected once in a transaction.'])->withInput();
        }

        // Save transaction
        $transaction = Transaction::create([
            'description' => $request->description,
            'type' => $request->type,
        ]);

        // Save transaction details
        foreach ($request->clothes_id as $index => $clothesId) {
            // Skip if no sizes are selected for this clothes
            if (!isset($request->size_id[$index]) || empty($request->size_id[$index])) {
                continue;
            }

            $usedSizes = []; // To track used sizes for this clothes

            foreach ($request->size_id[$index] as $sizeIndex => $sizeId) {
                // Validate: Check if size is already used for this clothes
                if (in_array($sizeId, $usedSizes)) {
                    return redirect()->back()->withErrors(['size_id' => 'Each size can only be selected once for each clothes item.'])->withInput();
                }

                // Get quantity for this size
                $quantity = $request->quantity[$index][$sizeIndex] ?? 1;

                // Check if size is custom
                $size = Size::find($sizeId);
                $isCustom = $size ? $size->is_custom : false;
                $customSize = null;

                // Get custom size value if the size is custom
                if ($isCustom && isset($request->custom_size[$index][$sizeIndex])) {
                    $customSize = $request->custom_size[$index][$sizeIndex];
                }

                // Save transaction detail
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'clothes_id' => $clothesId,
                    'size_id' => $sizeId,
                    'quantity' => $quantity,
                    'custom_size' => $customSize,
                ]);

                // Add size to used sizes list
                $usedSizes[] = $sizeId;
            }
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }

    // Menampilkan detail transaksi
    public function show(Transaction $transaction)
    {
        // Load the details relationship with clothes and size
        $transaction->load('details.clothes', 'details.size');
        return view('transactions.show', compact('transaction'));
    }


    public function edit(Transaction $transaction)
    {
        // Ambil semua data clothes dan sizes
        $clothes = Clothes::all();
        $sizes = Size::all();

        // Load relasi details dengan clothes dan size
        $transaction->load('details.clothes', 'details.size');

        return view('transactions.edit', compact('transaction', 'clothes', 'sizes'));
    }


    public function update(Request $request, Transaction $transaction)
    {
        // Validasi input
        $request->validate([
            'description' => 'nullable|string',
            'type' => 'required|in:in,out',
            'clothes_id' => 'required|array',
            'clothes_id.*' => 'exists:clothes,id',
            'size_id' => 'required|array',
            'size_id.*' => 'array', // Setiap clothes memiliki array sizes
            'size_id.*.*' => 'exists:sizes,id', // Setiap size harus valid
            'quantity' => 'required|array',
            'quantity.*' => 'array', // Setiap clothes memiliki array quantities
            'quantity.*.*' => 'integer|min:1', // Setiap quantity harus valid
            'custom_size' => 'nullable|array', // Custom size (opsional)
            'custom_size.*' => 'nullable|array', // Setiap clothes memiliki array custom sizes
            'custom_size.*.*' => 'nullable|string', // Setiap custom size harus string (jika ada)
        ]);

        // Validasi: Cek duplikat clothes dalam satu transaksi
        if (count($request->clothes_id) !== count(array_unique($request->clothes_id))) {
            return redirect()->back()->withErrors(['clothes_id' => 'Each clothes item can only be selected once in a transaction.'])->withInput();
        }

        // Mulai transaksi database untuk memastikan integritas data
        DB::beginTransaction();

        try {
            // Update data transaksi
            $transaction->update([
                'description' => $request->description,
                'type' => $request->type,
            ]);

            // Hapus detail transaksi lama
            $transaction->details()->delete();

            // Simpan detail transaksi baru
            foreach ($request->clothes_id as $index => $clothesId) {
                // Lewati jika tidak ada size yang dipilih untuk clothes ini
                if (!isset($request->size_id[$index]) || empty($request->size_id[$index])) {
                    continue;
                }

                $usedSizes = []; // Untuk melacak size yang sudah digunakan untuk clothes ini

                foreach ($request->size_id[$index] as $sizeIndex => $sizeId) {
                    // Validasi: Cek apakah size sudah digunakan untuk clothes ini
                    if (in_array($sizeId, $usedSizes)) {
                        throw new \Exception('Each size can only be selected once for each clothes item.');
                    }

                    // Ambil quantity untuk size ini
                    $quantity = isset($request->quantity[$index][$sizeIndex]) ? (int)$request->quantity[$index][$sizeIndex] : 1;

                    // Cek apakah size adalah custom
                    $size = Size::find($sizeId);
                    $isCustom = $size ? $size->is_custom : false;
                    $customSize = null;

                    // Ambil nilai custom size jika size adalah custom
                    if ($isCustom && isset($request->custom_size[$index][$sizeIndex])) {
                        $customSize = $request->custom_size[$index][$sizeIndex];
                    }

                    // Simpan detail transaksi
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'clothes_id' => $clothesId,
                        'size_id' => $sizeId,
                        'quantity' => $quantity,
                        'custom_size' => $customSize,
                    ]);

                    // Tambahkan size ke daftar size yang sudah digunakan
                    $usedSizes[] = $sizeId;
                }
            }

            // Commit transaksi database
            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi error
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }


    // Menghapus transaksi dari database
    public function destroy(Transaction $transaction)
    {
        $transaction->details()->delete(); // Use the correct relationship name
        $transaction->delete(); // Hapus transaksi
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
