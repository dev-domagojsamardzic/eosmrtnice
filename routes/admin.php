<?php

use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\Offers\AdOfferController;
use App\Http\Controllers\Admin\Offers\PostOfferController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\User\PostController;
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
    ->only(['index', 'create', 'edit', 'store', 'update']);

Route::get('ads', [AdController::class, 'index'])->name('ads.index');
Route::prefix('companies/{company}')->group(function () {
    Route::get('ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::put('ads/{ad}', [AdController::class, 'update'])->name('ads.update');
});

Route::resource('ads/{ad}/offers', AdOfferController::class)
    ->except(['index'])
    ->names('ads.offers');

Route::resource('posts/{post}/offers', PostOfferController::class)
    ->except(['index'])
    ->names('posts.offers');

Route::resource('posts', PostController::class);

Route::resource('offers', OfferController::class)
    ->only(['index', 'edit', 'update', 'delete']);
Route::get('offers/{offer}/send', [OfferController::class, 'send'])->name('offers.send');
Route::get('offers/{offer}/download', [OfferController::class, 'download'])->name('offers.download');
