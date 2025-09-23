<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyManagement\CompanyController;


Route::prefix('company_management')->name('company_management.')->group(function () {

    // Companies

    Route::get('/companies/fetch-ruc/{ruc}', [CompanyController::class, 'fetchRuc'])->name('companies.fetchRuc');
    Route::resource('companies', CompanyController::class)->names('companies');
    Route::get('companies/{company}/delete',        [CompanyController::class, 'delete'])    ->name('companies.delete');
    Route::delete('companies/{company}/deleteSave', [CompanyController::class, 'deleteSave'])->name('companies.deleteSave');

});