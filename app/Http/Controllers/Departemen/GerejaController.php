<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use App\Models\Gereja;
use App\Models\PerpindahanPendeta;
use App\Models\Region;
use App\Models\Pendeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class GerejaController extends Controller
{
    public function index()
    {
        $userRegionId = Auth::user()->region_id;
        $gerejas = Gereja::with(['region', 'pendetas'])->where('region_id', $userRegionId)->get();
        return view('departemen.gereja.index', compact('gerejas'));
    }

    public function create()
    {
        $userRegionId = Auth::user()->region_id;
        $regions = Region::where('id', $userRegionId)->get();
        $pendetas = Pendeta::where('region_id', $userRegionId)->get();
        return view('departemen.gereja.create', compact('regions', 'pendetas'));
    }

    public function store(Request $request)
    {
        $userRegionId = Auth::user()->region_id;
        $userDepartemenId = Auth::user()->departemen_id;

        $validator = Validator::make($request->all(), [
            'nama_gereja' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'region_id' => 'required|exists:regions,id|in:' . $userRegionId,
            'pendeta_ids' => 'nullable|array',
            'pendeta_ids.*' => 'exists:pendetas,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the gereja
        $gereja = Gereja::create($request->only(['nama_gereja', 'alamat', 'region_id']));

        // Assign pendetas to the gereja if selected
        if ($request->has('pendeta_ids')) {
            $pendetas = Pendeta::where('region_id', $userRegionId)
                              ->whereIn('id', $request->pendeta_ids)
                              ->get();

            foreach ($pendetas as $pendeta) {
                $oldGerejaId = $pendeta->gereja_id;
                $pendeta->update(['gereja_id' => $gereja->id]);
                if ($oldGerejaId !== $gereja->id) {
                    PerpindahanPendeta::create([
                        'pendeta_id' => $pendeta->id,
                        'region_asal_id' => $pendeta->region_id,
                        'region_tujuan_id' => null,
                        'gereja_asal_id' => $oldGerejaId,
                        'gereja_tujuan_id' => $gereja->id,
                        'tanggal_perpindahan' => now()->toDateString(),
                        'tanggal_aktif_melayani' => now()->toDateString(),
                    ]);
                }
            }
        }

        return redirect()->route('departemen.gereja.index')->with('success', 'Gereja berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $userRegionId = Auth::user()->region_id;
        $gereja = Gereja::with('pendetas')->where('region_id', $userRegionId)->findOrFail($id);
        $regions = Region::where('id', $userRegionId)->get();
        $pendetas = Pendeta::where('region_id', $userRegionId)->get();
        return view('departemen.gereja.edit', compact('gereja', 'regions', 'pendetas'));
    }

    public function update(Request $request, $id)
    {
        $userRegionId = Auth::user()->region_id;
        $userDepartemenId = Auth::user()->departemen_id;
        $gereja = Gereja::where('region_id', $userRegionId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_gereja' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'region_id' => 'required|exists:regions,id|in:' . $userRegionId,
            'pendeta_ids' => 'nullable|array',
            'pendeta_ids.*' => 'exists:pendetas,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update gereja basic info
        $gereja->update($request->only(['nama_gereja', 'alamat', 'region_id']));

        // Handle pendeta assignments
        // First, remove all current assignments for this gereja
        Pendeta::where('gereja_id', $gereja->id)->update(['gereja_id' => null]);

        // Then assign selected pendetas
        if ($request->has('pendeta_ids')) {
            $pendetas = Pendeta::where('region_id', $userRegionId)
                              ->whereIn('id', $request->pendeta_ids)
                              ->get();

            foreach ($pendetas as $pendeta) {
                $pendeta->update(['gereja_id' => $gereja->id]);
            }
        }

        return redirect()->route('departemen.gereja.index')->with('success', 'Gereja berhasil diperbarui.');
    }

    public function show($id)
    {
        $userRegionId = Auth::user()->region_id;
        $gereja = Gereja::with(['region', 'pendetas'])->where('region_id', $userRegionId)->findOrFail($id);
        return view('departemen.gereja.show', compact('gereja'));
    }

    public function destroy($id)
    {
        $userRegionId = Auth::user()->region_id;
        $gereja = Gereja::where('region_id', $userRegionId)->findOrFail($id);
        $gereja->delete();
        return redirect()->route('departemen.gereja.index')->with('success', 'Gereja berhasil dihapus.');
    }
}
