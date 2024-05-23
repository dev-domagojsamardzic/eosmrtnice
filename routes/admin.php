<?php

use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\Offers\AdOfferController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', static function () {
    return view('admin/dashboard');
})->name('dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::resource('partners',PartnerController::class)
    ->only(['index', 'edit', 'update']);

Route::resource('members', MemberController::class)
    ->only(['index', 'edit', 'update']);

Route::resource('companies', CompanyController::class)
    ->only(['index', 'edit', 'update']);

Route::get('ads', [AdController::class, 'index'])->name('ads.index');
Route::prefix('companies/{company}')->group(function () {
    Route::get('ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::put('ads/{ad}', [AdController::class, 'update'])->name('ads.update');
});

Route::resource('ads/{ad}/offers', AdOfferController::class)->names('ads.offers');
