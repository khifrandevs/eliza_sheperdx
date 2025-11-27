<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use App\Models\Pendeta;
use App\Models\Gereja;
use App\Models\Anggota;
use App\Models\PermohonanPerpindahan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userRegionId = Auth::user()->region_id;

        $totalPendetas = Pendeta::where('region_id', $userRegionId)->count();
        $newPendetasCount = Pendeta::where('region_id', $userRegionId)
            ->where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $totalGerejas = Gereja::where('region_id', $userRegionId)->count();
        $totalAnggotas = Anggota::whereHas('gereja', function ($query) use ($userRegionId) {
            $query->where('region_id', $userRegionId);
        })->count();
        $activePendetas = Pendeta::where('region_id', $userRegionId)
            ->whereHas('penjadwalans', function ($query) {
                $query->where('tanggal_selesai', '>=', Carbon::now());
            })->count();
        $recentPendetas = Pendeta::where('region_id', $userRegionId)
            ->with('region')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $permohonanCount = PermohonanPerpindahan::where('region_asal_id', $userRegionId)
            ->orWhere('region_tujuan_id', $userRegionId)
            ->count();

        return view('departemen.dashboard', compact(
            'totalPendetas', 'newPendetasCount', 'totalGerejas', 'totalAnggotas', 'activePendetas', 'recentPendetas', 'permohonanCount'
        ));
    }
}
