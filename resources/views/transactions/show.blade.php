@extends('layouts.app')

@section('content')
    <div class="mb-6 mt-10 md:mt-0 pt-5">
        <h2 class="text-2xl font-bold text-gray-800">Detail Transaction</h2>
        <p class="text-gray-600">View transaction details.</p>
    </div>

    <!-- Detail Section -->
    <div class="bg-white rounded-xl shadow-sm border border-pink-100 p-6">
        <!-- Description Field -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <p class="text-gray-900">{{ $transaction->description }}</p>
        </div>

        <!-- Type Field -->
        <!-- Type and Total Quantity Fields -->
        <div class="mb-6 flex justify-between">
            <!-- Type Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <p class="text-gray-900">
                    @if ($transaction->type === 'in')
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Barang Masuk</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Barang Keluar</span>
                    @endif
                </p>
            </div>

            <!-- Total Quantity Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Total Barang</label>
                <p class="text-gray-900 font-semibold">{{ $totalQuantity }}</p>
            </div>
        </div>



        <!-- Detail Transaksi Section -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Transaksi</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($transaction->details as $detail)
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <!-- Clothes -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Clothes</label>
                            <p class="text-gray-900">{{ $detail->clothes->name }}</p>
                        </div>

                        <!-- Size -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                            <p class="text-gray-900">{{ $detail->size->name }}</p>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <p class="text-gray-900">{{ $detail->quantity }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Back Button -->
        <div class="flex justify-end">
            <a href="{{ route('transactions.index') }}"
                class="px-6 py-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2">
                Kembali
            </a>
        </div>
    </div>

    <!-- Extra space at bottom for better scrolling experience -->
    <div class="h-10 md:h-20"></div>
@endsection
