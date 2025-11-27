<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// SuperAdmin Controllers with unique aliases
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\ProfileController as SuperAdminProfileController;
use App\Http\Controllers\SuperAdmin\RegionController as SuperAdminRegionController;
use App\Http\Controllers\SuperAdmin\PendetaController as SuperAdminPendetaController;
use App\Http\Controllers\SuperAdmin\DepartemenController as SuperAdminDepartemenController;
use App\Http\Controllers\SuperAdmin\PermohonanPerpindahanController as SuperAdminPermohonanPerpindahanController;
use App\Http\Controllers\SuperAdmin\LaporanController as SuperAdminLaporanController;

// Departemen Controllers with unique aliases
use App\Http\Controllers\Departemen\DashboardController as DepartemenDashboardController;
use App\Http\Controllers\Departemen\ProfileController as DepartemenProfileController;
use App\Http\Controllers\Departemen\AnggotaController as DepartemenAnggotaController;
use App\Http\Controllers\Departemen\GerejaController as DepartemenGerejaController;
use App\Http\Controllers\Departemen\PendetaController as DepartemenPendetaController;
use App\Http\Controllers\Departemen\RegionController as DepartemenRegionController;
use App\Http\Controllers\Departemen\PermohonanPerpindahanController as DepartemenPermohonanPerpindahanController;
use App\Http\Controllers\Departemen\LaporanController as DepartemenLaporanController;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// SuperAdmin Routes
Route::prefix('superadmin')->middleware('auth:superadmin')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');
    Route::get('profile/edit', [SuperAdminProfileController::class, 'edit'])->name('superadmin.profile.edit');
    Route::put('profile', [SuperAdminProfileController::class, 'update'])->name('superadmin.profile.update');
    Route::resource('region', SuperAdminRegionController::class)->names('superadmin.region');
    Route::get('pendeta/transfer', [SuperAdminPendetaController::class, 'transferForm'])->name('superadmin.pendeta.transfer.form');
    Route::post('pendeta/transfer', [SuperAdminPendetaController::class, 'transferSubmit'])->name('superadmin.pendeta.transfer.submit');
    Route::resource('pendeta', SuperAdminPendetaController::class)->names('superadmin.pendeta');
    Route::resource('departemen', SuperAdminDepartemenController::class)->names('superadmin.departemen');
    Route::resource('permohonan_perpindahan', SuperAdminPermohonanPerpindahanController::class)->names('superadmin.permohonan_perpindahan');
    Route::get('laporan', [SuperAdminLaporanController::class, 'index'])->name('superadmin.laporan.index');
    Route::get('laporan/export_excel/{pendeta_id}', [SuperAdminLaporanController::class, 'exportExcel'])->name('superadmin.laporan.export_excel');
    Route::get('laporan/export_pdf/{pendeta_id}', [SuperAdminLaporanController::class, 'exportPdf'])->name('superadmin.laporan.export_pdf');
});

// Departemen Routes
Route::prefix('departemen')->middleware('auth:departemen')->group(function () {
    Route::get('/dashboard', [DepartemenDashboardController::class, 'index'])->name('departemen.dashboard');
    Route::get('profile/edit', [DepartemenProfileController::class, 'edit'])->name('departemen.profile.edit');
    Route::put('profile', [DepartemenProfileController::class, 'update'])->name('departemen.profile.update');
    Route::resource('pendeta', DepartemenPendetaController::class)->names('departemen.pendeta');
    Route::get('pendeta/{pendeta}/perlawatan', [DepartemenPendetaController::class, 'perlawatan'])->name('departemen.pendeta.perlawatan');
    Route::post('pendeta/{pendeta}/perlawatan', [DepartemenPendetaController::class, 'storePerlawatan'])->name('departemen.pendeta.store_perlawatan');
    Route::get('pendeta/{pendeta}/penjadwalan', [DepartemenPendetaController::class, 'penjadwalan'])->name('departemen.pendeta.penjadwalan');
    Route::post('pendeta/{pendeta}/penjadwalan', [DepartemenPendetaController::class, 'storePenjadwalan'])->name('departemen.pendeta.store_penjadwalan');
    Route::resource('region', DepartemenRegionController::class)->names('departemen.region');
    Route::resource('gereja', DepartemenGerejaController::class)->names('departemen.gereja');
    Route::resource('anggota', DepartemenAnggotaController::class)->names('departemen.anggota');
    Route::resource('permohonan_perpindahan', DepartemenPermohonanPerpindahanController::class)->names('departemen.permohonan_perpindahan');
    Route::get('pendeta/{pendeta}/detail', [DepartemenPendetaController::class, 'detail'])->name('departemen.pendeta.detail');
    Route::get('laporan', [DepartemenLaporanController::class, 'index'])->name('departemen.laporan.index');
    Route::get('laporan/export_excel/{pendeta_id}', [DepartemenLaporanController::class, 'exportExcel'])->name('departemen.laporan.export_excel');
    Route::get('laporan/export_pdf/{pendeta_id}', [DepartemenLaporanController::class, 'exportPdf'])->name('departemen.laporan.export_pdf');
});
