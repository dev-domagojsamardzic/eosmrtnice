<?php

use App\Http\Controllers\Partner\AdController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Partner\CompanyController;

Route::get('/dashboard', static function () {
    return view('partner/dashboard');
})->name('dashboard');

Route::resource('companies', CompanyController::class)
    ->only(['index', 'create', 'edit', 'update', 'store']);

Route::get('ads', [AdController::class, 'index'])->name('ads.index');

Route::prefix('companies/{company}')->group(function () {
    Route::get('ads/create', [AdController::class, 'create'])->name('ads.create');
    Route::get('ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::post('ads', [AdController::class, 'store'])->name('ads.store');
    Route::put('ads/{ad}', [AdController::class, 'update'])->name('ads.update');
    Route::delete('ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');
});

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
