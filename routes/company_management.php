<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyManagement\CompanyController;

Route::prefix('company_management')->name('company_management.')->middleware(['auth'])->group(function () {

        // Rutas personalizadas primero (export, fetch, editAll, updateInline)
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
