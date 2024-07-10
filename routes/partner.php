<?php

use App\Http\Controllers\Admin\AdsOfferController;
use App\Http\Controllers\Partner\AdController;
use App\Http\Controllers\Partner\OfferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Partner\CompanyController;

Route::get('/dashboard', static function () {
    return view('partner/dashboard');
})->name('dashboard');

Route::resource('companies', CompanyController::class)
    ->only(['index', 'create', 'edit', 'update', 'store']);

Route::resource('ads', AdController::class)
    ->except('create');
Route::get('ads/{company}/create', [AdController::class, 'create'])->name('ads.create');

Route::resource('ads-offers', AdsOfferController::class)
    ->only(['index', 'show']);
Route::get('ads-offers/{ads_offer}/download', [AdsOfferController::class, 'download'])->name('ads-offers.download');


Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


