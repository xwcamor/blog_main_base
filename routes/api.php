<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LanguageApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api.token')->get('/user', function (Request $request) {
    return $request->user();
});

// Login for API token
Route::post('/login', [App\Http\Controllers\AuthManagement\Auth\LoginController::class, 'apiLogin']);

// API for Languages
Route::middleware('api.token')->group(function () {
    Route::apiResource('languages', LanguageApiController::class)->parameters([
        'languages' => 'language:slug'
    ]);
    Route::post('languages/{language}/deleteSave', [LanguageApiController::class, 'deleteSave'])->name('languages.deleteSave');
});