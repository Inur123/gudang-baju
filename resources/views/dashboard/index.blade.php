@extends('layouts.app')

@section('content')
<div class="mb-6 mt-10 md:mt-0 pt-5">

    <h2 class="text-2xl font-bold text-gray-800 ">Warehouse Dashboard</h2>
    <p class="text-gray-600">Welcome back! Here's what's happening today.</p>
</div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-pink-100 p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500">Total Baju</p>
          <p class="text-2xl font-bold text-gray-800">{{ $totalClothes }}</p>
        </div>
        <div class="h-12 w-12 bg-pink-100 rounded-lg flex items-center justify-center">
          <i class="ri-t-shirt-line text-pink-500 text-xl"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-green-100 p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500">Transaksi Masuk</p>
          <p class="text-2xl font-bold text-gray-800">{{ $totalTransactionsIn }}</p>
        </div>
        <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
          <i class="ri-inbox-archive-line text-green-500 text-xl"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500">Transaksi Keluar</p>
          <p class="text-2xl font-bold text-gray-800">{{ $totalTransactionsOut }}</p>
        </div>
        <div class="h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center">
          <i class="ri-inbox-unarchive-line text-orange-500 text-xl"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500">Total Transaksi</p>
          <p class="text-2xl font-bold text-gray-800">{{ $totalTransactions }}</p>
        </div>
        <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
          <i class="ri-archive-line text-purple-500 text-xl"></i>
        </div>
      </div>
    </div>
  </div>
@endsection
