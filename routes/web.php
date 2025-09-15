<?php

// Use Illuminates
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Use Controllers
use App\Http\Controllers\AuthManagement\UserController;
use App\Http\Controllers\SettingManagement\CountryController;
use App\Http\Controllers\AuthManagement\Auth\LoginController;
use App\Http\Controllers\LocaleController;

// Localization
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// ------------------------------
// Languages sources
// ------------------------------
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [
            'localeSessionRedirect',
            'localizationRedirect',
            'localeViewPath'
        ],
    ],
    function () {

        // Rutas protegidas con login
        Route::middleware(['auth'])->group(function () {

            // Ruta raíz
            Route::get('/', function () {
                return Auth::check()
                    ? redirect()->route('auth_management.users.index')
                    : redirect()->route('login');
            });

            // Países
            Route::prefix('setting_management')->name('setting_management.')->group(function () {
                Route::resource('countries', CountryController::class)->names('countries');
                Route::get('countries/{country}/delete',        [CountryController::class, 'delete'])    ->name('countries.delete');
                Route::delete('countries/{country}/deleteSave', [CountryController::class, 'deleteSave'])->name('countries.deleteSave');
            });

            // Usuarios
            Route::prefix('auth_management')->name('auth_management.')->group(function () {
                Route::resource('users', UserController::class)->names('users');
                Route::get('users/{user}/delete',        [UserController::class, 'delete'])    ->name('users.delete');
                Route::delete('users/{user}/deleteSave', [UserController::class, 'deleteSave'])->name('users.deleteSave');
            });
        });

        // Login (se muestran también dentro del prefijo)
        Route::get('login',   [LoginController::class, 'login'])->name('login');
        Route::post('login',  [LoginController::class, 'loginAccess'])->name('login.post');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/terms', function () {
            return view('legal.terms');
        })->name('terms');

        Route::get('/privacy', function () {
            return view('legal.privacy');
        })->name('privacy');

    }
);
 