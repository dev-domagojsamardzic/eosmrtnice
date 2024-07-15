<?php

use App\Http\Controllers\Guest\FlowersCompanyAdController;
use App\Http\Controllers\Guest\FuneralCompanyAdController;
use App\Http\Controllers\Guest\HomepageController;
use App\Http\Controllers\Guest\MasonryCompanyAdController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\Partner\RegisteredUserController as PartnerRegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomepageController::class, 'home'])->name('homepage');
Route::post('/',[HomepageController::class, 'items'])->name('homepage.items');
Route::post('/search',[HomepageController::class, 'search'])->name('homepage.search');


Route::middleware('guest')->group(function () {
    // user register
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])
        ->name('register');

    // partner register
    Route::get('partner/register', [PartnerRegisteredUserController::class, 'create'])
        ->name('partner.register');
    Route::post('partner/register', [PartnerRegisteredUserController::class, 'store'])
        ->name('partner.register');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // ImageController
    Route::post('images/upload', [ImageController::class, 'upload'])->name('images.upload');
    Route::delete('images/upload/revert', [ImageController::class, 'revert'])->name('images.upload.revert');
});

Route::group(['as' => 'guest.'], static function() {
    Route::get('pogrebna-poduzeca', [FuneralCompanyAdController::class, 'funerals'])->name('funerals');
    Route::post('pogrebna-poduzeca', [FuneralCompanyAdController::class, 'items'])->name('funerals.items');
    Route::get('klesari', [MasonryCompanyAdController::class, 'masonries'])->name('masonries');
    Route::post('klesari', [MasonryCompanyAdController::class, 'items'])->name('masonries.items');
    Route::get('cvjecari', [FlowersCompanyAdController::class, 'flowers'])->name('flowers');
    Route::post('cvjecari', [FlowersCompanyAdController::class, 'items'])->name('flowers.items');
});

