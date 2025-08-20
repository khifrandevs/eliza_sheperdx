<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PendetaController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\AnggotaController;
use App\Http\Controllers\Api\PerlawatanController;
use App\Http\Controllers\Api\PenjadwalanController;
use App\Http\Controllers\Api\ChatController;

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
        Route::put('update-profile', [AuthController::class, 'updateProfile']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('permohonan', [AuthController::class, 'permohonan']);
        Route::get('permohonan', [AuthController::class, 'listPermohonan']);

        Route::apiResource('perlawatan', PerlawatanController::class);
        Route::apiResource('penjadwalan', PenjadwalanController::class);

        // Chat routes
        Route::post('chat/send', [ChatController::class, 'sendMessage']);
        Route::get('chat/conversations', [ChatController::class, 'getConversations']);
        Route::get('chat/conversation/{pendetaId}', [ChatController::class, 'getConversation']);
        Route::get('chat/pendeta-list', [ChatController::class, 'getPendetaList']);
        Route::post('chat/mark-read', [ChatController::class, 'markAsRead']);
        Route::get('chat/unread-count', [ChatController::class, 'getUnreadCount']);
    });
});
