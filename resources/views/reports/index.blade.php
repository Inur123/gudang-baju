@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="mb-6 mt-10 md:mt-0 pt-5">
        <h2 class="text-2xl font-bold text-gray-800">Laporan Transaksi</h2>
        <p class="text-gray-600">Lihat dan analisis riwayat transaksi Anda.</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Transactions Card -->
        <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Barang Tersedia</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="total-items">{{ $totalItems }}</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-8 8h8m-8-4h10M5 6h14V4H5m0 16h14v-2H5v2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Items In Card -->
        <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Barang Masuk</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="total-in">{{ $totalIn }}</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Items Out Card -->
        <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Barang Keluar</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="total-out">{{ $totalOut }}</h3>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-xl shadow-lg border border-pink-200 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Grafik Transaksi</h3>
        <div class="h-80">
            <canvas id="transaction-chart"></canvas> <!-- Ini adalah tempat grafik akan dirender -->
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-xl shadow-sm border border-pink-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Detail Transaksi</h3>
            <div class="flex space-x-2">
                <button id="export-csv"
                    class="px-3 py-1.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <i class="ri-file-excel-line mr-1"></i> Export CSV
                </button>
                <button id="export-pdf"
                    class="px-3 py-1.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <i class="ri-file-pdf-line mr-1"></i> Export PDF
                </button>
                <button id="print-report"
                    class="px-3 py-1.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="ri-printer-line mr-1"></i> Print
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Deskripsi</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                            Kuantitas</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="transactions-table-body">
                    @foreach ($transactions as $index => $transaction)
                        <!-- Menambah variabel index untuk nomor urut -->
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td> <!-- Nomor urut -->
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($transaction->created_at)->translatedFormat('l, d F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($transaction->type === 'in')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Barang
                                        Masuk</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Barang
                                        Keluar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $transaction->description }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @foreach ($transaction->details as $detail)
                                    {{ $detail->clothes->name }} ({{ $detail->size->name }}),
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $transaction->details->sum('quantity') }} <!-- Total quantity dari detail transaksi -->
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <button class="text-blue-500 hover:underline">Edit</button>
                                <button class="text-red-500 hover:underline">Hapus</button>
                            </td>
                        </tr>
                    @endforeach

                    @if ($transactions->isEmpty())
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-sm text-gray-600">
                Showing
                {{ ($transactions->currentPage() - 1) * $transactions->perPage() + 1 }}-{{ min($transactions->currentPage() * $transactions->perPage(), $transactions->total()) }}
                of {{ $transactions->total() }} transactions
            </p>
            <div class="flex space-x-2">
                <!-- Previous Button -->
                <a href="{{ $transactions->previousPageUrl() }}"
                    class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50 {{ $transactions->onFirstPage() ? 'disabled' : '' }}">
                    Previous
                </a>

                <!-- Pagination Numbers -->
                @php
                    $currentPage = $transactions->currentPage();
                    $lastPage = $transactions->lastPage();
                    $start = max($currentPage - 2, 1);
                    $end = min($start + 4, $lastPage);

                    if ($end - $start < 4 && $lastPage > 5) {
                        $start = max($lastPage - 4, 1);
                        $end = $lastPage;
                    }
                @endphp

                @if ($start > 1)
                    <a href="{{ $transactions->url(1) }}"
                        class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">
                        1
                    </a>
                    @if ($start > 2)
                        <span class="px-3 py-1 text-gray-600">...</span>
                    @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    <a href="{{ $transactions->url($i) }}"
                        class="px-3 py-1 rounded {{ $currentPage == $i ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white' : 'border border-gray-300 text-gray-600 hover:bg-gray-50' }}">
                        {{ $i }}
                    </a>
                @endfor

                @if ($end < $lastPage)
                    @if ($end < $lastPage - 1)
                        <span class="px-3 py-1 text-gray-600">...</span>
                    @endif
                    <a href="{{ $transactions->url($lastPage) }}"
                        class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">
                        {{ $lastPage }}
                    </a>
                @endif

                <!-- Next Button -->
                <a href="{{ $transactions->nextPageUrl() }}"
                    class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50 {{ $transactions->hasMorePages() ? '' : 'disabled' }}">
                    Next
                </a>
            </div>
        </div>
    </div>


    <!-- Back Button -->
    <div class="flex justify-end mt-6">
        <a href="{{ route('reports.index') }}"
            class="px-6 py-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2">Kembali</a>
    </div>

    <div class="h-10 md:h-20"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('transaction-chart').getContext('2d');
            const transactionChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Barang Masuk', 'Barang Keluar', 'Barang Tersedia'],
                    datasets: [{
                        label: 'Total Kuantitas',
                        data: [{{ $totalIn }}, {{ $totalOut }}, {{ $totalItems }}],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.7)', // Warna lebih cerah
                            'rgba(255, 99, 132, 0.7)', // Warna lebih cerah
                            'rgba(255, 206, 86, 0.7)' // Warna lebih cerah
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 2, // Ganti border width jadi lebih tebal
                        borderRadius: 5 // Rounded corners
                    }]
                },
                options: {
                    responsive: true, // Membuat grafik responsif
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Kuantitas', // Menambahkan judul sumbu Y
                                color: 'gray',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Jenis Transaksi', // Menambahkan judul sumbu X
                                color: 'gray',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top', // Menempatkan legend di atas
                            labels: {
                                font: {
                                    size: 12, // Ukuran font legend
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.dataset.label + ': ' + tooltipItem
                                    .raw; // Custom tooltip format
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
