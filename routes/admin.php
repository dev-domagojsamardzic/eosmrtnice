<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PartnerController;

Route::get('/dashboard', static function () {
    return view('admin/dashboard');
})->name('dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::resource('partners',PartnerController::class)
    ->only(['index', 'edit', 'update']);

Route::resource('users', UserController::class)
    ->only(['index', 'edit', 'update']);

Route::resource('companies', CompanyController::class)
    ->only(['index', 'edit', 'update']);
