<?php

use App\Http\Controllers\Partner\AdController;
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

Route::resource('ads', AdController::class)
    ->except('create');
Route::get('ads/{company}/create', [AdController::class, 'create'])->name('ads.create');

Route::resource('posts', PostController::class);

/* Posts offers*/
Route::get('posts-offers/{post}/create', [PostOfferController::class, 'create'])->name('posts-offers.create');
Route::get('posts-offers/{posts_offer}/send', [PostOfferController::class, 'send'])->name('posts-offers.send');
Route::get('posts-offers/{posts_offer}/download', [PostOfferController::class, 'download'])->name('posts-offers.download');
Route::resource('posts-offers', PostOfferController::class)->except('create')->names('posts-offers');

/* Ads offers*/
Route::get('ads-offers/{ad}/create', [AdsOfferController::class, 'create'])->name('ads-offers.create');
Route::get('ads-offers/{ads_offer}/send', [AdsOfferController::class, 'send'])->name('ads-offers.send');
Route::get('ads-offers/{ads_offer}/download', [AdsOfferController::class, 'download'])->name('ads-offers.download');
Route::resource('ads-offers', AdsOfferController::class)->except('create')->names('ads-offers');
