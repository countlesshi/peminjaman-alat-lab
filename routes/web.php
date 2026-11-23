<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AdminLoanController;
use App\Http\Controllers\ItemQrController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    return Auth::user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('borrower.catalog');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', fn () => view('admin.dashboard', ['stats' => \App\Models\Loan::stats()]))
        ->name('admin.dashboard');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('items', ItemController::class)->except('show');

            Route::get('loans', [AdminLoanController::class, 'index'])->name('loans.index');
            Route::patch('loans/{loan}/handover', [AdminLoanController::class, 'handover'])->name('loans.handover');
            Route::patch('loans/{loan}/receive', [AdminLoanController::class, 'receive'])->name('loans.receive');

            Route::get('items/{item}/qr', [ItemQrController::class, 'show'])->name('items.qr');
            Route::get('items/{item}/scan', [ItemQrController::class, 'scan'])->name('items.scan');
        });
    });

    Route::middleware('role:borrower')->group(function () {
        Route::get('/katalog', [CatalogController::class, 'index'])->name('borrower.catalog');
        Route::get('/katalog/{item}/pesan', [LoanController::class, 'create'])->name('borrower.loans.create');
        Route::post('/katalog/{item}/pesan', [LoanController::class, 'store'])->name('borrower.loans.store');
        Route::get('/riwayat', [LoanController::class, 'index'])->name('borrower.loans.index');
    });
});