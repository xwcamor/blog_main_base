<?php

// Use Illuminates
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; //For Auth check

// Use Controllers
use App\Http\Controllers\AuthManagement\UserController;  
use App\Http\Controllers\SettingManagement\CountryController;
use App\Http\Controllers\AuthManagement\Auth\LoginController;

Route::middleware(['auth'])->group(function () {
    // Route root
    Route::get('/', function () {
        // Check if user is logged in
        if (Auth::check()) {
            return redirect()->route('auth_management.users.index'); // Redirect to dashboard if logged in
        }

        // 
        return redirect()->route('login');
    });
    


    // Route for countries
    Route::prefix('setting_management')->name('setting_management.')->group(function () {
        Route::resource('countries', CountryController::class)->names('countries');
        Route::get('countries/{country}/delete',        [CountryController::class, 'delete'])    ->name('countries.delete');
        Route::delete('countries/{country}/deleteSave', [CountryController::class, 'deleteSave'])->name('countries.deleteSave');
    });

    // Route for users
    Route::prefix('auth_management')->name('auth_management.')->group(function () {
        Route::resource('users', UserController::class)->names('users');
        Route::get('users/{user}/delete',        [UserController::class, 'delete'])    ->name('users.delete');
        Route::delete('users/{user}/deleteSave', [UserController::class, 'deleteSave'])->name('users.deleteSave');
    });

});

    // Route for Authentication
    Route::get('login',   [LoginController::class, 'login'])->name('login');
    Route::post('login',  [LoginController::class, 'loginAccess'])->name('login.post');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

