<?php

use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\AdsOfferController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PostOfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\PostController;
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
    ->only(['index', 'create', 'edit', 'store', 'update']);

Route::get('ads', [AdController::class, 'index'])->name('ads.index');
Route::prefix('companies/{company}')->group(function () {
    Route::get('ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::put('ads/{ad}', [AdController::class, 'update'])->name('ads.update');
});

Route::resource('posts/{post}/offers', PostOfferController::class)
    ->except(['index'])
    ->names('posts.offers');

Route::resource('posts', PostController::class);

Route::resource('ads-offers', AdsOfferController::class)->names('ads-offers');

Route::get('ads-offers/{ads_offer}/send', [AdsOfferController::class, 'send'])->name('ads-offers.send');
Route::get('ads-offers/{ads_offer}/download', [AdsOfferController::class, 'download'])->name('ads-offers.download');
