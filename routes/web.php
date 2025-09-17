<?php

// Use Illuminates
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

// Use Controllers
use App\Http\Controllers\AuthManagement\Auth\LoginController;
use App\Http\Controllers\AuthManagement\Auth\GoogleLoginController;
use App\Http\Controllers\AuthManagement\Auth\ForgotPasswordController;
use App\Http\Controllers\AuthManagement\Auth\ResetPasswordController;
use App\Http\Controllers\AuthManagement\UserController;
use App\Http\Controllers\SettingManagement\CountryController;
//use App\Http\Controllers\LocaleController;

// Localization
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// ------------------------------
// Languages sources
// ------------------------------
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect','localizationRedirect','localeViewPath' ],
    ],
    function () {

        // Protected by auth
        Route::middleware(['auth'])->group(function () {

            // Main 
            Route::get('/', function () {
                return Auth::check()
                    ? redirect()->route('auth_management.users.index')
                    : redirect()->route('login');
            });

            // Setting Management
            Route::prefix('setting_management')->name('setting_management.')->group(function () {
                // Countries
                Route::resource('countries', CountryController::class)->names('countries');
                Route::get('countries/{country}/delete',        [CountryController::class, 'delete'])    ->name('countries.delete');
                Route::delete('countries/{country}/deleteSave', [CountryController::class, 'deleteSave'])->name('countries.deleteSave');
                Route::get('countries/live_edit', [CountryController::class, 'liveEdit'])->name('countries.live_edit');
                Route::post('countries/update_inline', [CountryController::class, 'updateInline'])->name('countries.update_inline');                
                Route::get('countries/export_excel', [CountryController::class, 'exportExcel'])->name('countries.export_excel');
                Route::get('countries/export_pdf', [CountryController::class, 'exportPdf'])->name('countries.export_pdf');
            });

            // Auth Management
            Route::prefix('auth_management')->name('auth_management.')->group(function () {
                // Users
                Route::resource('users', UserController::class)->names('users');
                Route::get('users/{user}/delete',        [UserController::class, 'delete'])    ->name('users.delete');
                Route::delete('users/{user}/deleteSave', [UserController::class, 'deleteSave'])->name('users.deleteSave');
            });
        });

        // Login
        Route::get('login',   [LoginController::class, 'login'])->name('login');
        Route::post('login',  [LoginController::class, 'loginAccess'])->name('login.post');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');


        // Google login
        Route::prefix('auth_management')->name('auth_management.')->group(function () {
            Route::controller(GoogleLoginController::class)->group(function () {
                Route::get('google/redirect', 'redirectToGoogle')->name('google.redirect');
                Route::get('google/callback', 'handleGoogleCallback')->name('google.callback');
            });
        });

        // Forgot password
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->middleware('guest')->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->middleware('guest')->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->middleware('guest')->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->middleware('guest')->name('password.update');

        // Legal
        Route::view('/terms', 'legal.terms')->name('terms');
        Route::view('/privacy', 'legal.privacy')->name('privacy');        
    

    }
);
 