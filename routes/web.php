<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product routes
    Route::resource('products', ProductController::class);

    // Customer routes
    Route::resource('customers', CustomerController::class);

    // Transaction routes
    Route::get('transactions/{transaction}/invoice-pdf', [TransactionController::class, 'invoicePdf'])->name('transactions.invoice-pdf');
    Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'show']);
});

require __DIR__.'/auth.php';
