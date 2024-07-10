<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\OfferController;
use App\Http\Controllers\User\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', static function () {
    return view('user/dashboard');
})->name('dashboard');

Route::resource('posts', PostController::class)->names('posts');

Route::resource('offers', OfferController::class)
    ->only(['index', 'show']);
Route::get('offers/{offer}/download', [OfferController::class, 'download'])->name('offers.download');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
