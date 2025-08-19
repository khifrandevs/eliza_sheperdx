<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:superadmin')->group(function () {
    Route::get('/superadmin/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('superadmin.dashboard');
});

Route::middleware('auth:departemen')->group(function () {
    Route::get('/departemen/dashboard', function () {
        return view('departemen.dashboard');
    })->name('departemen.dashboard');
});