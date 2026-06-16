<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MemoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureTwoFactorIsAuthenticated;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/phpinfo', function () {
    phpinfo();
});
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])
    ->name('password.email');

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login']);

    Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register']);

    Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [PasswordController::class, 'resetPassword'])
        ->name('password.update');
});

Route::middleware(['auth', 'twofactor'])->group(function () {
    Route::get('/dashboard', [UserAuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/settings/appearance', [SettingsController::class, 'appearance'])->name('settings.appearance');
    Route::get('/settings/notifications', [SettingsController::class, 'notifications'])->name('settings.notifications');
    Route::get('/settings/security', [SettingsController::class, 'security'])->name('settings.security');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/change-password', [PasswordController::class, 'showChangePassword'])->name('password.change');
    Route::put('/change-password', [PasswordController::class, 'updatePassword'])->name('password.change.update');
    Route::get('/two-factor/setup', [TwoFactorController::class, 'setupForm'])->name('two-factor.setup');
    Route::post('/two-factor/setup', [TwoFactorController::class, 'setup'])->name('two-factor.setup.store');
    Route::get('/two-factor/disable', [TwoFactorController::class, 'disableForm'])->name('two-factor.disable');
    Route::post('/two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable.store');
    Route::get('/two-factor/verify', [TwoFactorController::class, 'verifyForm'])->name('two-factor.verify');
    Route::post('/two-factor/verify', [TwoFactorController::class, 'verify'])->name('two-factor.verify.store');
    Route::post('/two-factor/resend', [TwoFactorController::class, 'resend'])->name('two-factor.resend');

    // --- Memories Routes ---
    // 1. Static / Explicit Routes First
    Route::get('/memories', [MemoryController::class, 'index'])->name('memories.index');
    Route::get('/memories/create', [MemoryController::class, 'create'])->name('memories.create');
    Route::get('/memories/search', [MemoryController::class, 'search'])->name('memories.search');
    Route::post('/memories', [MemoryController::class, 'store'])->name('memories.store');

    // 2. Wildcard / Dynamic Routes Last (with number constraints)
    Route::get('/memories/{id}', [MemoryController::class, 'show'])->name('memories.show')->whereNumber('id');
    Route::get('/memories/{id}/edit', [MemoryController::class, 'edit'])->name('memories.edit')->whereNumber('id');
    Route::put('/memories/{id}', [MemoryController::class, 'update'])->name('memories.update')->whereNumber('id');
    Route::delete('/memories/{id}', [MemoryController::class, 'destroy'])->name('memories.destroy')->whereNumber('id');
    Route::patch('/memories/{id}/favorite', [MemoryController::class, 'toggleFavorite'])->name('memories.favorite')->whereNumber('id');
});


Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::get('/lang/{lang}', [LanguageController::class, 'switch']);

Route::view('/help-center', 'pages.help-center')->name('help-center');
Route::view('/terms-of-service', 'pages.terms')->name('terms');
Route::view('/privacy-policy', 'pages.privacy')->name('privacy');