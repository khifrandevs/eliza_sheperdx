<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::with('region')->get();
        return view('superadmin.departemen.index', compact('departemens'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('superadmin.departemen.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
            'nama_departemen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'region_id' => 'required|exists:regions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Generate unique id_akun
        $id_akun = $this->generateUniqueIdAkun();

        $data = $request->all();
        $data['id_akun'] = $id_akun;
        $data['password'] = Hash::make($request->password);
        Departemen::create($data);
        return redirect()->route('superadmin.departemen.index')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $departemen = Departemen::findOrFail($id);
        $regions = Region::all();
        return view('superadmin.departemen.edit', compact('departemen', 'regions'));
    }

    public function update(Request $request, $id)
    {
        $departemen = Departemen::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id_akun' => 'required|string|max:50|unique:departemens,id_akun,' . $id,
            'password' => 'nullable|string|min:6',
            'nama_departemen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'region_id' => 'required|exists:regions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }
        $departemen->update($data);
        return redirect()->route('superadmin.departemen.index')->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();
        return redirect()->route('superadmin.departemen.index')->with('success', 'Departemen berhasil dihapus.');
    }

    private function generateUniqueIdAkun()
    {
        do {
            $number = rand(1, 99999); // Generate random number between 1 and 99999
            $id_akun = 'DP' . str_pad($number, 5, '0', STR_PAD_LEFT); // Format as DP00001
        } while (Departemen::where('id_akun', $id_akun)->exists()); // Check for uniqueness

        return $id_akun;
    }
}