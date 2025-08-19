<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    // Test route to debug authentication
    Route::get('/test-auth', function () {
        return response()->json(['message' => 'No auth required']);
    });

            Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        
        // Test route to debug authenticated requests
        Route::get('/test-authenticated', function () {
            return response()->json(['message' => 'Authenticated successfully']);
        });
    });
});
