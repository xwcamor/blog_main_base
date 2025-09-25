<?php

use App\Http\Controllers\AuthManagement\AuthController;
use App\Http\Controllers\SystemManagement\Languages\Api\LanguageApiController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

Route::middleware(['api.key', 'api.language', 'api.response.wrapper'])->apiResource('languages', LanguageApiController::class);