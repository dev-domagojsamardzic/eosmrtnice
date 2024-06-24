<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\User\DeceasedController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\OfferController;

Route::get('/dashboard', static function () {
    return view('user/dashboard');
})->name('dashboard');

Route::resource('deceased', DeceasedController::class)->names('deceaseds');

Route::get('posts', [PostController::class, 'index'])->name('posts.index');

Route::prefix('deceased/{deceased}')->group(function () {
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
});

Route::resource('offers', OfferController::class)
    ->only(['index', 'show']);
Route::get('offers/{offer}/download', [OfferController::class, 'download'])->name('offers.download');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
