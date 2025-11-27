<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pendeta;
use App\Models\Departemen;
use App\Models\Region;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendetas = Pendeta::count();
        $newPendetasCount = Pendeta::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $totalDepartemens = Departemen::count();
        $totalRegions = Region::count();
        $activePendetas = Pendeta::whereHas('penjadwalans', function ($query) {
            $query->where('tanggal_selesai', '>=', Carbon::now());
        })->count(); // Asumsi pendeta aktif jika punya jadwal yang belum selesai
        $recentPendetas = Pendeta::with('region')->orderBy('created_at', 'desc')->take(5)->get();

        return view('superadmin.dashboard', compact(
            'totalPendetas',
            'newPendetasCount',
            'totalDepartemens',
            'totalRegions',
            'activePendetas',
            'recentPendetas'
        ));
    }
}