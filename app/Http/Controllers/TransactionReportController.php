<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Clothes;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class TransactionReportController extends Controller
{
    public function index()
    {
        $totalIn = TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('type', 'in');
        })->sum('quantity');

        $totalOut = TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('type', 'out');
        })->sum('quantity');

        $totalItems = $totalIn - $totalOut;

        // Tambahkan orderBy untuk mengurutkan data dari yang terbaru
        $transactions = Transaction::with('details')
            ->orderBy('created_at', 'desc') // Urutkan dari transaksi terbaru ke yang lama
            ->paginate(10); // Sesuaikan jumlah data per halaman

        $clothes = Clothes::all();
        $sizes = Size::all();

        return view('reports.index', compact('totalIn', 'totalOut', 'totalItems', 'transactions', 'clothes', 'sizes'));
    }
}
