<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
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
        Route::get('/admin', fn () => view('admin.dashboard'))->name('admin.dashboard');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('items', ItemController::class)->except('show');
        });
    });

    Route::middleware('role:borrower')->group(function () {
        Route::get('/katalog', fn () => view('borrower.catalog'))->name('borrower.catalog');
    });
});