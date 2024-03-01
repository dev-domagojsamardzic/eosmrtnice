<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('partner/dashboard');
})->name('dashboard');
