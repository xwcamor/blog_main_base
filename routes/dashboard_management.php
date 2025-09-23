<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardManagement\DashboardController;

Route::prefix('dashboard_management')->name('dashboard_management.')->group(function () {
    // Dashboards
    Route::resource('dashboards', DashboardController::class)->names('dashboards');
});