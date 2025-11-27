<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        return view('superadmin.region.index', compact('regions'));
    }

    public function create()
    {
        return view('superadmin.region.create');
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
        return redirect()->route('superadmin.region.index')->with('success', 'Region berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $region = Region::findOrFail($id);
        return view('superadmin.region.edit', compact('region'));
    }

    public function update(Request $request, $id)
    {
        $region = Region::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_region' => 'required|string|max:255',
            'kode_region' => 'required|string|max:50|unique:regions,kode_region,' . $id,
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $region->update($request->all());
        return redirect()->route('superadmin.region.index')->with('success', 'Region berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $region->delete();
        return redirect()->route('superadmin.region.index')->with('success', 'Region berhasil dihapus.');
    }
}