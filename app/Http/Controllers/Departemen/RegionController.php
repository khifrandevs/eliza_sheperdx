<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    public function index()
    {
        $userRegionId = Auth::user()->region_id;
        $regions = Region::where('id', $userRegionId)->get();
        return view('departemen.region.index', compact('regions'));
    }

    public function create()
    {
        return view('departemen.region.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_region' => 'required|string|max:255',
            'kode_region' => 'required|string|max:50|unique:regions',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Region::create($request->all());
        return redirect()->route('departemen.region.index')->with('success', 'Region berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $userRegionId = Auth::user()->region_id;
        $region = Region::where('id', $userRegionId)->findOrFail($id);
        return view('departemen.region.edit', compact('region'));
    }

    public function update(Request $request, $id)
    {
        $userRegionId = Auth::user()->region_id;
        $region = Region::where('id', $userRegionId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_region' => 'required|string|max:255',
            'kode_region' => 'required|string|max:50|unique:regions,kode_region,' . $id,
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $region->update($request->all());
        return redirect()->route('departemen.region.index')->with('success', 'Region berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $userRegionId = Auth::user()->region_id;
        $region = Region::where('id', $userRegionId)->findOrFail($id);
        $region->delete();
        return redirect()->route('departemen.region.index')->with('success', 'Region berhasil dihapus.');
    }
}
