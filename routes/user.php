<?php

use App\Http\Controllers\Admin\PostOfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\OfferController;
use App\Http\Controllers\User\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', static function () {
    return view('user/dashboard');
})->name('dashboard');

Route::resource('posts', PostController::class)->names('posts');

Route::resource('posts-offers', PostOfferController::class)
    ->except('create')
    ->names('posts-offers');
Route::get('posts-offers/{post}/create', [PostOfferController::class, 'create'])->name('posts-offers.create');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
