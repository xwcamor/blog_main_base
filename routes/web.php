<?php

// Use Illuminates
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

// Use Controllers mandatory
use App\Http\Controllers\AuthManagement\Auth\LoginController;
use App\Http\Controllers\AuthManagement\Auth\GoogleLoginController;
use App\Http\Controllers\AuthManagement\Auth\ForgotPasswordController;
use App\Http\Controllers\AuthManagement\Auth\ResetPasswordController;
use App\Http\Controllers\AuthManagement\UserController;
use App\Http\Controllers\SystemManagement\SettingController;
use App\Http\Controllers\SystemManagement\CountryController;
use App\Http\Controllers\SystemManagement\LanguageController;
use App\Http\Controllers\DownloadManagement\UserDownloadController;
use App\Http\Controllers\CompanyManagement\CompanyController;
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

            Route::prefix('download_management')->name('download_management.user_downloads.')->group(function () {
                Route::get('/', [UserDownloadController::class, 'index'])->name('index');
                 Route::get('/ajax/latest', [UserDownloadController::class, 'getLatest'])->name('latest');
                Route::get('/{id}/download', [UserDownloadController::class, 'download'])->name('download');
                Route::delete('/{id}', [UserDownloadController::class, 'delete'])->name('delete');
            });


            // System Management
            Route::prefix('system_management')->name('system_management.')->group(function () {

                // Languages - Export routes BEFORE resource routes
                Route::get('languages/export_excel', [LanguageController::class, 'exportExcel'])->name('languages.export_excel');
                Route::get('languages/export_pdf', [LanguageController::class, 'exportPdf'])->name('languages.export_pdf');
                Route::get('languages/export_word', [LanguageController::class, 'exportWord'])->name('languages.export_word');
                Route::get('languages/edit_all', [LanguageController::class, 'editAll'])->name('languages.edit_all');
                Route::post('languages/update_inline', [LanguageController::class, 'updateInline'])->name('languages.update_inline');
                
                // Languages resource routes
                Route::resource('languages', LanguageController::class)->names('languages');
                Route::get('languages/{language}/delete',        [LanguageController::class, 'delete'])    ->name('languages.delete');
                Route::delete('languages/{language}/deleteSave', [LanguageController::class, 'deleteSave'])->name('languages.deleteSave');                

                // Settings
                Route::resource('settings', SettingController::class)->names('settings');
                Route::get('settings/{setting}/delete', [SettingController::class, 'delete'])->name('settings.delete');
                Route::delete('settings/{setting}/deleteSave', [SettingController::class, 'deleteSave'])->name('settings.deleteSave');
                Route::get('settings/live_edit', [SettingController::class, 'liveEdit'])->name('settings.live_edit');
                Route::post('settings/update_inline', [SettingController::class, 'updateInline'])->name('settings.update_inline');                
                Route::get('settings/export_excel', [SettingController::class, 'exportExcel'])->name('settings.export_excel');
                Route::get('settings/export_pdf', [SettingController::class, 'exportPdf'])->name('settings.export_pdf');


                // Countries
                Route::resource('countries', CountryController::class)->names('countries');
                Route::get('countries/{country}/delete', [CountryController::class, 'delete'])->name('countries.delete');
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
                Route::get('users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
                Route::delete('users/{user}/deleteSave', [UserController::class, 'deleteSave'])->name('users.deleteSave');
            });

            Route::prefix('company_management')->name('company_management.')->middleware(['auth'])->group(function () {
            Route::get('companies/fetch-dni/{num_doc}', [CompanyController::class, 'fetchDni'])->name('companies.fetch_dni');
            Route::get('companies/export_excel', [CompanyController::class, 'exportExcel'])->name('companies.export_excel');
            Route::get('companies/export_pdf', [CompanyController::class, 'exportPdf'])->name('companies.export_pdf');
            Route::get('companies/export_word', [CompanyController::class, 'exportWord'])->name('companies.export_word');
            Route::get('companies/edit_all', [CompanyController::class, 'editAll'])->name('companies.edit_all');
            Route::post('companies/update_inline', [CompanyController::class, 'updateInline'])->name('companies.update_inline');
            Route::resource('companies', CompanyController::class)->names('companies');
            Route::get('companies/{company}/delete', [CompanyController::class, 'delete'])->name('companies.delete');
            Route::delete('companies/{company}/deleteSave', [CompanyController::class, 'deleteSave'])->name('companies.deleteSave');
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
 