<?php

use App\Http\Controllers\Admin\PostOfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', static function () {
    return view('user/dashboard');
})->name('dashboard');

Route::resource('posts', PostController::class)->names('posts');

Route::resource('posts-offers', PostOfferController::class)
    ->only(['index'])
    ->names('posts-offers');
Route::get('posts-offers/{posts_offer}/download', [PostOfferController::class, 'download'])->name('posts-offers.download');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
