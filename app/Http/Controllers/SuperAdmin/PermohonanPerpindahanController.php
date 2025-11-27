<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PermohonanPerpindahan;
use App\Models\Pendeta;
use App\Models\Region;
use App\Models\RegionPendeta;
use App\Models\PerpindahanPendeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PermohonanPerpindahanController extends Controller
{
    public function index()
    {
        $permohonans = PermohonanPerpindahan::with(['pendeta', 'regionAsal', 'regionTujuan'])->get();
        return view('superadmin.permohonan_perpindahan.index', compact('permohonans'));
    }

    public function create()
    {
        $pendetas = Pendeta::all();
        $regions = Region::all();
        return view('superadmin.permohonan_perpindahan.create', compact('pendetas', 'regions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pendeta_id' => 'required|exists:pendetas,id',
            'region_asal_id' => 'required|exists:regions,id',
            'region_tujuan_id' => 'required|exists:regions,id|different:region_asal_id',
            'alasan' => 'required|string',
            'tanggal_permohonan' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        PermohonanPerpindahan::create($request->all());
        return redirect()->route('superadmin.permohonan_perpindahan.index')->with('success', 'Permohonan perpindahan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $permohonan = PermohonanPerpindahan::findOrFail($id);
        $pendetas = Pendeta::all();
        $regions = Region::all();
        return view('superadmin.permohonan_perpindahan.edit', compact('permohonan', 'pendetas', 'regions'));
    }

    public function update(Request $request, $id)
    {
        $permohonan = PermohonanPerpindahan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'pendeta_id' => 'required|exists:pendetas,id',
            'region_asal_id' => 'required|exists:regions,id',
            'region_tujuan_id' => 'required|exists:regions,id|different:region_asal_id',
            'alasan' => 'required|string',
            'status' => 'required|in:pending,disetujui,ditolak',
            'tanggal_permohonan' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request, $permohonan) {
            $permohonan->update($request->all());

            if ($request->input('status') === 'disetujui') {
                $pendeta = Pendeta::findOrFail($permohonan->pendeta_id);

                $effectiveDate = $request->input('tanggal_permohonan') ?? now()->toDateString();

                $currentHistory = RegionPendeta::where('pendeta_id', $pendeta->id)
                    ->whereNull('tanggal_akhir')
                    ->orderByDesc('tanggal_awal')
                    ->first();
                if ($currentHistory) {
                    $currentHistory->update(['tanggal_akhir' => $effectiveDate]);
                }

                RegionPendeta::create([
                    'pendeta_id' => $pendeta->id,
                    'region_id' => $permohonan->region_tujuan_id,
                    'tanggal_awal' => $effectiveDate,
                ]);

                $pendeta->update(['region_id' => $permohonan->region_tujuan_id]);

                PerpindahanPendeta::create([
                    'pendeta_id' => $pendeta->id,
                    'region_asal_id' => $permohonan->region_asal_id,
                    'region_tujuan_id' => $permohonan->region_tujuan_id,
                    'gereja_asal_id' => $pendeta->gereja_id,
                    'gereja_tujuan_id' => null,
                    'tanggal_perpindahan' => $effectiveDate,
                    'tanggal_aktif_melayani' => $effectiveDate,
                ]);
            }
        });

        return redirect()->route('superadmin.permohonan_perpindahan.index')->with('success', 'Permohonan perpindahan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $permohonan = PermohonanPerpindahan::findOrFail($id);
        $permohonan->delete();
        return redirect()->route('superadmin.permohonan_perpindahan.index')->with('success', 'Permohonan perpindahan berhasil dihapus.');
    }
}
