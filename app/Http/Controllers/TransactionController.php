<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Clothes;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil transaksi dengan relasi details
        $transactions = Transaction::with(['details.clothes', 'details.size'])
            ->paginate(10); // Sesuaikan jumlah pagination

        // Hitung total barang dari semua transaksi
        $totalItems = $transactions->sum(function ($transaction) {
            return $transaction->details->sum('quantity');
        });

        return view('transactions.index', compact('transactions', 'totalItems'));
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
        ]);

        // Validate: Check for duplicate clothes in one transaction
        if (count($request->clothes_id) !== count(array_unique($request->clothes_id))) {
            return redirect()->back()->withErrors(['clothes_id' => 'Each clothes item can only be selected once in a transaction.'])->withInput();
        }

        // Save transaction with explicit created_at
        $transaction = Transaction::create([
            'description' => $request->description,
            'type' => $request->type,
            'created_at' => Carbon::now(), // Set waktu sekarang
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

                // Save transaction detail with explicit created_at
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'clothes_id' => $clothesId,
                    'size_id' => $sizeId,
                    'quantity' => $quantity,
                    'custom_size' => null, // No custom size input needed
                    'created_at' => Carbon::now(), // Set waktu sekarang
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

        // Hitung total quantity semua barang
        $totalQuantity = $transaction->details->sum('quantity');

        return view('transactions.show', compact('transaction', 'totalQuantity'));
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

                    // Simpan detail transaksi
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'clothes_id' => $clothesId,
                        'size_id' => $sizeId,
                        'quantity' => $quantity,
                        'custom_size' => null, // No custom size input needed
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
