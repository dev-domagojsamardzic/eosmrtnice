<?php

use App\Http\Controllers\Guest\CondolenceController;
use App\Http\Controllers\Guest\FlowersCompanyAdController;
use App\Http\Controllers\Guest\FuneralCompanyAdController;
use App\Http\Controllers\Guest\HomepageController;
use App\Http\Controllers\Guest\MasonryCompanyAdController;
use App\Http\Controllers\Guest\Posts\DeathNoticeController;
use App\Http\Controllers\Guest\Posts\LastGoodbyeController;
use App\Http\Controllers\Guest\Posts\MemoryController;
use App\Http\Controllers\Guest\Posts\ThankYouController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Guest\PostController;
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
Route::get('pretraga',[HomepageController::class, 'search'])->name('homepage.search');

Route::post('zapali-svijecu', [PostController::class, 'candle'])->name('posts.candle');

Route::get('osmrtnice/{post}/{slug?}', [PostController::class, 'show'])->name('posts.show');

Route::get('obavijesti-o-smrti',[DeathNoticeController::class, 'index'])->name('guest.death-notices');
Route::post('obavijesti-o-smrti', [DeathNoticeController::class, 'items'])->name('guest.death-notices.items');

Route::get('sjecanja',[MemoryController::class, 'index'])->name('guest.memories');
Route::post('sjecanja', [MemoryController::class, 'items'])->name('guest.memories.items');

Route::get('posljednji-pozdravi',[LastGoodbyeController::class, 'index'])->name('guest.last-goodbyes');
Route::post('posljednji-pozdravi', [LastGoodbyeController::class, 'items'])->name('guest.last-goodbyes.items');

Route::get('zahvale',[ThankYouController::class, 'index'])->name('guest.thank-yous');
Route::post('zahvale', [ThankYouController::class, 'items'])->name('guest.thank-yous.items');

Route::get('posalji-sucut', [CondolenceController::class, 'create'])->name('guest.condolences.create');
Route::post('posalji-sucut', [CondolenceController::class, 'store'])->name('guest.condolences.store');
Route::get('posalji-sucut/hvala',[CondolenceController::class, 'thankyou'])
    ->name('guest.condolences.thank-you');
Route::middleware('guest')->group(function () {
    // user register
    Route::get('registracija', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('registracija', [RegisteredUserController::class, 'store'])
        ->name('register.store');

    // partner register
    Route::get('partner/registracija', [PartnerRegisteredUserController::class, 'create'])
        ->name('partner.register');
    Route::post('partner/registracija', [PartnerRegisteredUserController::class, 'store'])
        ->name('partner.register.store');

    Route::get('prijava', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('prijava', [AuthenticatedSessionController::class, 'store']);

    Route::get('zaboravljena-lozinka', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('zaboravljena-lozinka', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('email-verifikacija', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('email-potvrda/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/potvrdna-obavijest', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('potvrda-lozinke', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('potvrda-lozinke', [ConfirmablePasswordController::class, 'store']);

    Route::put('lozinka', [PasswordController::class, 'update'])->name('password.update');

    Route::post('odjava', [AuthenticatedSessionController::class, 'destroy'])
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
    Route::get('uvjeti-kupovine', function() {
        return view('guest.legal.terms-of-sale');
    })->name('terms-of-sale');
});

