<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\FundraiserController;
use App\Http\Controllers\FundraisingController;
use App\Http\Controllers\FundraisingPhaseController;
use App\Http\Controllers\FundraisingWithdrawalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function() {
        Route::resource('categories', CategoryController::class)->middleware('role:owner');

        Route::resource('donaturs', DonaturController::class)->middleware('role:owner');

        Route::resource('fundraisers', FundraiserController::class)->middleware('role:owner')->except('index');

        Route::get('fundtraisers', [FundraiserController::class, 'index'])->name('fundraisers.index');

        Route::resource('fundraising_withdrawals', FundraisingWithdrawalController::class)->middleware('role:owner|fundraiser');

        Route::resource('fundraising_phases', FundraisingPhaseController::class)->middleware('role:owner|fundraiser');

        Route::resource('fundraisings', FundraisingController::class)->middleware('role:owner|fundraiser');
    });
});

require __DIR__.'/auth.php';
