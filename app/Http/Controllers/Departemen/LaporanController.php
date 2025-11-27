<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use App\Models\Pendeta;
use App\Exports\DepartemenPendetaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $userRegionId = Auth::user()->region_id;
        $pendetas = Pendeta::where('region_id', $userRegionId)
            ->withCount([
                'perlawatans' => fn($query) => $query->whereBetween('tanggal', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]),
                'penjadwalans' => fn($query) => $query->whereBetween('tanggal_mulai', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])
            ])->get()->map(function ($pendeta) {
                $pendeta->jumlah_perlawatan = $pendeta->perlawatans_count;
                $pendeta->jumlah_penjadwalan = $pendeta->penjadwalans_count;
                $pendeta->kategori = $this->getKategori($pendeta->jumlah_perlawatan);
                return $pendeta;
            })->filter(function ($pendeta) {
                // Only show pendetas who did at least one visit this month
                return $pendeta->jumlah_perlawatan > 0;
            });

        return view('departemen.laporan.index', compact('pendetas'));
    }

    public function exportExcel($pendeta_id)
    {
        $userRegionId = Auth::user()->region_id;
        $pendeta = Pendeta::where('id', $pendeta_id)
            ->where('region_id', $userRegionId)
            ->with([
                'perlawatans' => fn($query) => $query->whereBetween('tanggal', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])->select('id', 'pendeta_id', 'anggota_id', 'tanggal', 'lokasi', 'catatan', 'gambar_bukti'),
                'penjadwalans' => fn($query) => $query->whereBetween('tanggal_mulai', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])->select('id', 'pendeta_id', 'judul_kegiatan', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai', 'lokasi')
            ])->withCount([
                'perlawatans' => fn($query) => $query->whereBetween('tanggal', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]),
                'penjadwalans' => fn($query) => $query->whereBetween('tanggal_mulai', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])
            ])->firstOrFail();

        $pendeta->jumlah_perlawatan = $pendeta->perlawatans_count;
        $pendeta->jumlah_penjadwalan = $pendeta->penjadwalans_count;
        $pendeta->kategori = $this->getKategori($pendeta->jumlah_perlawatan);

        return Excel::download(new DepartemenPendetaExport($pendeta), 'laporan_pendeta_' . str_replace(' ', '_', $pendeta->nama_pendeta) . '_' . Carbon::now()->format('Ymd') . '.xlsx');
    }

    public function exportPdf($pendeta_id)
    {
        $userRegionId = Auth::user()->region_id;
        $pendeta = Pendeta::where('id', $pendeta_id)
            ->where('region_id', $userRegionId)
            ->with([
                'perlawatans' => fn($query) => $query->whereBetween('tanggal', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])->select('id', 'pendeta_id', 'anggota_id', 'tanggal', 'lokasi', 'catatan', 'gambar_bukti'),
                'penjadwalans' => fn($query) => $query->whereBetween('tanggal_mulai', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])->select('id', 'pendeta_id', 'judul_kegiatan', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai', 'lokasi')
            ])->withCount([
                'perlawatans' => fn($query) => $query->whereBetween('tanggal', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]),
                'penjadwalans' => fn($query) => $query->whereBetween('tanggal_mulai', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])
            ])->firstOrFail();

        $pendeta->jumlah_perlawatan = $pendeta->perlawatans_count;
        $pendeta->jumlah_penjadwalan = $pendeta->penjadwalans_count;
        $pendeta->kategori = $this->getKategori($pendeta->jumlah_perlawatan);

        $pdf = Pdf::loadView('departemen.laporan.pdf', compact('pendeta'));
        return $pdf->download('laporan_pendeta_' . str_replace(' ', '_', $pendeta->nama_pendeta) . '_' . Carbon::now()->format('Ymd') . '.pdf');
    }

    private function getKategori($jumlahPerlawatan)
    {
        if ($jumlahPerlawatan <= 2) {
            return 'Cukup';
        } elseif ($jumlahPerlawatan <= 4) {
            return 'Baik';
        } else {
            return 'Sangat Bagus';
        }
    }
}
