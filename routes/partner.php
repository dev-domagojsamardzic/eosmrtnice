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
Route::resource('ads', AdController::class)
    ->only(['index', 'create', 'edit', 'update', 'store']);

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
