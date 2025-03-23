<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Size;
use App\Models\Clothes;
use Barryvdh\DomPDF\Facade\Pdf; // Perhatikan huruf besar/kecil
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;


class TransactionReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaction::with('details')
            ->orderBy('created_at', 'desc');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $transactions = $query->paginate(10);

        $totalIn = TransactionDetail::whereHas('transaction', function ($query) use ($startDate, $endDate) {
            $query->where('type', 'in');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        })->sum('quantity');

        $totalOut = TransactionDetail::whereHas('transaction', function ($query) use ($startDate, $endDate) {
            $query->where('type', 'out');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        })->sum('quantity');

        $totalItems = $totalIn - $totalOut;

        $clothes = Clothes::all();
        $sizes = Size::all();

        return view('reports.index', compact('totalIn', 'totalOut', 'totalItems', 'transactions', 'clothes', 'sizes'));
    }


    // Method untuk menangani ekspor data
    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query data transaksi berdasarkan filter tanggal
        $transactions = Transaction::with('details.clothes', 'details.size')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Format data untuk ekspor
        $data = [];
        foreach ($transactions as $index => $transaction) {
            $items = [];
            foreach ($transaction->details as $detail) {
                $items[] = [
                    'name' => $detail->clothes->name,
                    'size' => $detail->size->name,
                    'quantity' => $detail->quantity,
                ];
            }

            $data[] = [
                'No' => $index + 1,
                'Tanggal' => Carbon::parse($transaction->created_at)->format('d/m/Y'),
                'Tipe' => $transaction->type === 'in' ? 'Barang Masuk' : 'Barang Keluar',
                'Deskripsi' => $transaction->description,
                'Items' => $items, // Rincian item
                'Total Kuantitas' => $transaction->details->sum('quantity'),
            ];
        }

        // Tentukan format ekspor (CSV atau PDF)
        $format = $request->input('format');

        if ($format === 'csv') {
            return $this->exportCSV($data);
        } elseif ($format === 'pdf') {
            return $this->exportPDF($data, $startDate, $endDate);
        }

        return redirect()->back()->with('error', 'Format ekspor tidak valid.');
    }

    // Method untuk ekspor CSV
    private function exportCSV($data)
    {
        // Format nama file: "Senin, 20 Oktober 2022.csv"
        $fileName = Carbon::now()->translatedFormat('l, d F Y') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, ['No', 'Tanggal', 'Tipe', 'Deskripsi', 'Item', 'Total Kuantitas']);

            $totalBarang = 0;

            foreach ($data as $row) {
                // Format item ke dalam string
                $items = '';
                foreach ($row['Items'] as $item) {
                    $items .= $item['name'] . ' (' . $item['size'] . ') - Total: ' . $item['quantity'] . "\n";
                }

                fputcsv($file, [
                    $row['No'],
                    $row['Tanggal'],
                    $row['Tipe'],
                    $row['Deskripsi'],
                    trim($items),
                    $row['Total Kuantitas'],
                ]);

                $totalBarang += $row['Total Kuantitas'];
            }

            // Tambahkan footer untuk total barang
            fputcsv($file, ['', '', '', '', 'Total Barang', $totalBarang]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Method untuk ekspor PDF
    private function exportPDF($data, $startDate, $endDate)
    {
        // Format nama file: "Senin, 20 Oktober 2022.pdf"
        $fileName = Carbon::now()->translatedFormat('l, d F Y') . '.pdf';

        $pdf = PDF::loadView('reports.export_pdf', [
            'data' => $data,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        return $pdf->download($fileName);
    }

    public function exportSingle($id, Request $request)
    {
        // Ambil data transaksi berdasarkan ID
        $transaction = Transaction::with('details.clothes', 'details.size')->findOrFail($id);

        // Format data untuk ekspor
        $data = [
            'No' => 1,
            'Tanggal' => Carbon::parse($transaction->created_at)->format('d/m/Y'),
            'Tipe' => $transaction->type === 'in' ? 'Barang Masuk' : 'Barang Keluar',
            'Deskripsi' => $transaction->description,
            'Items' => $transaction->details->map(function ($detail) {
                return [
                    'name' => $detail->clothes->name,
                    'size' => $detail->size->name,
                    'quantity' => $detail->quantity,
                ];
            }),
            'Total Kuantitas' => $transaction->details->sum('quantity'),
        ];

        // Tentukan format ekspor (PDF)
        $format = $request->input('format');

        if ($format === 'pdf') {
            // Format nama file sesuai permintaan: "Senin, 20 Oktober 2022 - Barang Keluar.pdf"
            $fileName = Carbon::parse($transaction->created_at)->translatedFormat('l, d F Y') . ' - ' . $data['Tipe'] . '.pdf';

            // Load view untuk PDF
            $pdf = Pdf::loadView('reports.export_single_pdf', [
                'data' => $data,
            ]);

            // Download file PDF dengan nama yang sudah diformat
            return $pdf->download($fileName);
        }

        return redirect()->back()->with('error', 'Format ekspor tidak valid.');
    }
}
