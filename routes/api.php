<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PendetaController;
use App\Http\Controllers\Api\RegionController; 
use App\Http\Controllers\Api\AnggotaController; 
use App\Http\Controllers\Api\PerlawatanController;
use App\Http\Controllers\Api\PenjadwalanController;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/verify-token', [AuthController::class, 'verifyToken']);
    Route::get('getPendeta', [PendetaController::class, 'index']); 
    Route::get('getRegion', [RegionController::class, 'index']); 
    Route::get('getAnggota', [AnggotaController::class, 'index']); 

    Route::middleware('auth:api')->group(function () {
        Route::get('verify-token', [AuthController::class, 'verifyToken']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']); 

        Route::apiResource('perlawatan', PerlawatanController::class);
        Route::apiResource('penjadwalan', PenjadwalanController::class);
    });
});
