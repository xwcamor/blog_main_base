<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DownloadManagement\UserDownloadController;

Route::prefix('download_management')->name('download_management.user_downloads.')->group(function () {
    Route::get('/', [UserDownloadController::class, 'index'])->name('index');
    Route::get('/ajax/latest', [UserDownloadController::class, 'getLatest'])->name('latest');
    Route::get('/{id}/download', [UserDownloadController::class, 'download'])->name('download');
    Route::delete('/{id}', [UserDownloadController::class, 'delete'])->name('delete');
});