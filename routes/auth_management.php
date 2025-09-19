<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManagement\Auth\LoginController;
use App\Http\Controllers\AuthManagement\Auth\GoogleLoginController;
use App\Http\Controllers\AuthManagement\Auth\ForgotPasswordController;
use App\Http\Controllers\AuthManagement\Auth\ResetPasswordController;
use App\Http\Controllers\AuthManagement\UserController;

// ------------------------------
// Login / Logout
// ------------------------------
Route::get('login',   [LoginController::class, 'login'])->name('login');
Route::post('login',  [LoginController::class, 'loginAccess'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// ------------------------------
// Google Login
// ------------------------------
Route::prefix('auth_management')
    ->name('auth_management.')
    ->group(function () {
        Route::controller(GoogleLoginController::class)->group(function () {
            Route::get('google/redirect', 'redirectToGoogle')->name('google.redirect');
            Route::get('google/callback', 'handleGoogleCallback')->name('google.callback');
        });
    });

// ------------------------------
// Password Reset
// ------------------------------
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');

// ------------------------------
// Users (protected by auth)
// ------------------------------
Route::prefix('auth_management')
    ->name('auth_management.')
    ->middleware(['auth'])
    ->group(function () {
        Route::resource('users', UserController::class)->names('users');
        Route::get('users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
        Route::delete('users/{user}/deleteSave', [UserController::class, 'deleteSave'])->name('users.deleteSave');
    });
