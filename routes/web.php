<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ClothesController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClothesSizeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionReportController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Login Routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Register Routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk clothes
Route::resource('clothes', ClothesController::class);

// Route untuk sizes
Route::resource('sizes', SizeController::class);

// Route untuk transactions
Route::resource('transactions', TransactionController::class);

Route::get('/reports', [TransactionReportController::class, 'index'])->name('reports.index');
// routes/web.php
Route::get('/reports/export', [TransactionReportController::class, 'export'])->name('reports.export');
Route::get('/reports/{id}', [TransactionReportController::class, 'show'])->name('reports.show');
// routes/web.php
Route::get('/reports/export/{id}', [TransactionReportController::class, 'exportSingle'])->name('reports.export.single');

