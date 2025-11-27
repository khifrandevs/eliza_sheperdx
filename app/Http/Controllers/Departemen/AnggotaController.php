<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Gereja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    public function index()
    {
        $userRegionId = Auth::user()->region_id;
        $anggotas = Anggota::with('gereja')
            ->whereHas('gereja', function ($query) use ($userRegionId) {
                $query->where('region_id', $userRegionId);
            })->get();
        return view('departemen.anggota.index', compact('anggotas'));
    }

    public function create()
    {
        $userRegionId = Auth::user()->region_id;
        $gerejas = Gereja::where('region_id', $userRegionId)->get();
        return view('departemen.anggota.create', compact('gerejas'));
    }

    public function store(Request $request)
    {
        $userRegionId = Auth::user()->region_id;
        $validator = Validator::make($request->all(), [
            'nama_anggota' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'gereja_id' => 'required|exists:gerejas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi gereja_id di region user
        $gereja = Gereja::where('region_id', $userRegionId)->find($request->gereja_id);
        if (!$gereja) {
            return redirect()->back()->withErrors(['gereja_id' => 'Gereja tidak valid untuk region Anda.'])->withInput();
        }

        Anggota::create($request->all());
        return redirect()->route('departemen.anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $userRegionId = Auth::user()->region_id;
        $anggota = Anggota::whereHas('gereja', function ($query) use ($userRegionId) {
            $query->where('region_id', $userRegionId);
        })->findOrFail($id);
        $gerejas = Gereja::where('region_id', $userRegionId)->get();
        return view('departemen.anggota.edit', compact('anggota', 'gerejas'));
    }

    public function update(Request $request, $id)
    {
        $userRegionId = Auth::user()->region_id;
        $anggota = Anggota::whereHas('gereja', function ($query) use ($userRegionId) {
            $query->where('region_id', $userRegionId);
        })->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_anggota' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'gereja_id' => 'required|exists:gerejas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi gereja_id di region user
        $gereja = Gereja::where('region_id', $userRegionId)->find($request->gereja_id);
        if (!$gereja) {
            return redirect()->back()->withErrors(['gereja_id' => 'Gereja tidak valid untuk region Anda.'])->withInput();
        }

        $anggota->update($request->all());
        return redirect()->route('departemen.anggota.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $userRegionId = Auth::user()->region_id;
        $anggota = Anggota::whereHas('gereja', function ($query) use ($userRegionId) {
            $query->where('region_id', $userRegionId);
        })->findOrFail($id);
        $anggota->delete();
        return redirect()->route('departemen.anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
