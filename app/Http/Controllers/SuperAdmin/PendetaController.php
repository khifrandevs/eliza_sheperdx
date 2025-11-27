<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pendeta;
use App\Models\Region;
use App\Models\Departemen;
use App\Models\Gereja;
use App\Models\Jabatan;
use App\Models\JabatanPendeta;
use App\Models\RegionPendeta;
use App\Models\PerpindahanPendeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PendetaController extends Controller
{
    public function index()
    {
        $pendetas = Pendeta::with([
            'region', 'departemen', 'gereja',
            'jabatanHistories' => function ($q) {
                $q->whereNull('tanggal_akhir')->orderByDesc('tanggal_awal');
            },
            'jabatanHistories.jabatan'
        ])->get();
        return view('superadmin.pendeta.index', compact('pendetas'));
    }

    public function create()
    {
        $regions = Region::all();
        $departemens = Departemen::with('region')->get();
        $gerejas = Gereja::with('region')->get();
        $allowedNames = ['Gembala Jemaat', 'Direktur Kependetaan Departemen'];
        $jabatans = Jabatan::whereIn('jabatan', $allowedNames)->get();
        return view('superadmin.pendeta.create', compact('regions', 'departemens', 'gerejas', 'jabatans'));
    }

    public function store(Request $request)
    {
        $allowedNames = ['Gembala Jemaat', 'Direktur Kependetaan Departemen'];
        $allowedIds = Jabatan::whereIn('jabatan', $allowedNames)->pluck('id')->toArray();
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
            'nama_pendeta' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'region_id' => 'required|exists:regions,id',
            'departemen_id' => 'required|exists:departemens,id',
            'gereja_id' => 'nullable|exists:gerejas,id',
            'jabatan_id' => 'nullable|in:' . implode(',', $allowedIds),
            'jabatan_tanggal_awal' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->departemen_id) {
            $departemen = Departemen::find($request->departemen_id);
            if ($departemen && $departemen->region_id != $request->region_id) {
                return redirect()->back()->withErrors(['departemen_id' => 'Departemen harus berada di region yang dipilih.'])->withInput();
            }
        }
        if ($request->gereja_id) {
            $gereja = Gereja::find($request->gereja_id);
            if ($gereja && $gereja->region_id != $request->region_id) {
                return redirect()->back()->withErrors(['gereja_id' => 'Gereja harus berada di region yang dipilih.'])->withInput();
            }
        }

        // Generate unique id_akun
        $id_akun = $this->generateUniqueIdAkun();

        $data = $request->all();
        $data['id_akun'] = $id_akun;
        $data['password'] = Hash::make($request->password);
        $pendeta = Pendeta::create($data);

        if ($request->filled('jabatan_id')) {
            JabatanPendeta::create([
                'pendeta_id' => $pendeta->id,
                'jabatan_id' => $request->jabatan_id,
                'gereja_id' => $pendeta->gereja_id,
                'tanggal_awal' => $request->jabatan_tanggal_awal ?? now()->toDateString(),
            ]);
        }
        return redirect()->route('superadmin.pendeta.index')->with('success', 'Pendeta berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pendeta = Pendeta::findOrFail($id);
        $regions = Region::all();
        $departemens = Departemen::with('region')->get();
        $gerejas = Gereja::with('region')->get();
        $allowedNames = ['Gembala Jemaat', 'Direktur Kependetaan Departemen'];
        $jabatans = Jabatan::whereIn('jabatan', $allowedNames)->get();
        $jabatanAktif = JabatanPendeta::where('pendeta_id', $pendeta->id)->whereNull('tanggal_akhir')->orderByDesc('tanggal_awal')->first();
        return view('superadmin.pendeta.edit', compact('pendeta', 'regions', 'departemens', 'gerejas', 'jabatans', 'jabatanAktif'));
    }

    public function update(Request $request, $id)
    {
        $pendeta = Pendeta::findOrFail($id);
        $allowedNames = ['Gembala Jemaat', 'Direktur Kependetaan Departemen'];
        $allowedIds = Jabatan::whereIn('jabatan', $allowedNames)->pluck('id')->toArray();

        $validator = Validator::make($request->all(), [
            'id_akun' => 'required|string|max:50|unique:pendetas,id_akun,' . $id,
            'password' => 'nullable|string|min:6',
            'nama_pendeta' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'region_id' => 'required|exists:regions,id',
            'departemen_id' => 'required|exists:departemens,id',
            'gereja_id' => 'nullable|exists:gerejas,id',
            'jabatan_id' => 'nullable|in:' . implode(',', $allowedIds),
            'jabatan_tanggal_awal' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->departemen_id) {
            $departemen = Departemen::find($request->departemen_id);
            if ($departemen && $departemen->region_id != $request->region_id) {
                return redirect()->back()->withErrors(['departemen_id' => 'Departemen harus berada di region yang dipilih.'])->withInput();
            }
        }
        if ($request->gereja_id) {
            $gereja = Gereja::find($request->gereja_id);
            if ($gereja && $gereja->region_id != $request->region_id) {
                return redirect()->back()->withErrors(['gereja_id' => 'Gereja harus berada di region yang dipilih.'])->withInput();
            }
        }

        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }
        $data['region_id'] = $pendeta->region_id;
        $data['departemen_id'] = $pendeta->departemen_id;
        $data['gereja_id'] = $pendeta->gereja_id;
        $pendeta->update($data);

        if ($request->filled('jabatan_id')) {
            $jabatanAktif = JabatanPendeta::where('pendeta_id', $pendeta->id)
                ->whereNull('tanggal_akhir')
                ->orderByDesc('tanggal_awal')
                ->first();
            if (!$jabatanAktif || $jabatanAktif->jabatan_id != $request->jabatan_id || $jabatanAktif->gereja_id != $pendeta->gereja_id) {
                if ($jabatanAktif) {
                    $jabatanAktif->update(['tanggal_akhir' => now()->toDateString()]);
                }
                JabatanPendeta::create([
                    'pendeta_id' => $pendeta->id,
                    'jabatan_id' => $request->jabatan_id,
                    'gereja_id' => $pendeta->gereja_id,
                    'tanggal_awal' => $request->input('jabatan_tanggal_awal', now()->toDateString()),
                ]);
            }
        }
        return redirect()->route('superadmin.pendeta.index')->with('success', 'Pendeta berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendeta = Pendeta::findOrFail($id);
        $pendeta->delete();
        return redirect()->route('superadmin.pendeta.index')->with('success', 'Pendeta berhasil dihapus.');
    }

    public function show($id)
    {
        $pendeta = Pendeta::where('id', $id)->with([
            'region', 'departemen', 'gereja',
            'regionHistories' => function ($q) {
                $q->orderByDesc('tanggal_awal');
            },
            'regionHistories.region'
        ])->firstOrFail();
        return view('superadmin.pendeta.show', compact('pendeta'));
    }

    public function transferForm()
    {
        $pendetas = Pendeta::with(['region', 'gereja'])->get();
        $regions = Region::all();
        $gerejas = Gereja::with('region')->get();
        return view('superadmin.pendeta.transfer', compact('pendetas', 'regions', 'gerejas'));
    }

    public function transferSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pendeta_id' => 'required|exists:pendetas,id',
            'region_tujuan_id' => 'required|exists:regions,id',
            'gereja_tujuan_id' => 'nullable|exists:gerejas,id',
            'tanggal_perpindahan' => 'required|date',
            'tanggal_aktif_melayani' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pendeta = Pendeta::with(['region', 'gereja'])->findOrFail($request->pendeta_id);
        $regionTujuanId = (int) $request->region_tujuan_id;
        $gerejaTujuanId = $request->gereja_tujuan_id ? (int) $request->gereja_tujuan_id : null;

        if ($gerejaTujuanId) {
            $gerejaTujuan = Gereja::findOrFail($gerejaTujuanId);
            if ($gerejaTujuan->region_id !== $regionTujuanId) {
                return redirect()->back()->withErrors(['gereja_tujuan_id' => 'Gereja tujuan harus berada di region tujuan.'])->withInput();
            }
        }

        DB::transaction(function () use ($request, $pendeta, $regionTujuanId, $gerejaTujuanId) {
            $effectiveDate = $request->tanggal_perpindahan;

            $currentHistory = RegionPendeta::where('pendeta_id', $pendeta->id)
                ->whereNull('tanggal_akhir')
                ->orderByDesc('tanggal_awal')
                ->first();
            if ($currentHistory) {
                $currentHistory->update(['tanggal_akhir' => $effectiveDate]);
            }

            RegionPendeta::create([
                'pendeta_id' => $pendeta->id,
                'region_id' => $regionTujuanId,
                'tanggal_awal' => $effectiveDate,
            ]);

            PerpindahanPendeta::create([
                'pendeta_id' => $pendeta->id,
                'region_asal_id' => $pendeta->region_id,
                'region_tujuan_id' => $regionTujuanId,
                'gereja_asal_id' => $pendeta->gereja_id,
                'gereja_tujuan_id' => $gerejaTujuanId,
                'tanggal_perpindahan' => $request->tanggal_perpindahan,
                'tanggal_aktif_melayani' => $request->tanggal_aktif_melayani,
            ]);

            $pendeta->update([
                'region_id' => $regionTujuanId,
                'gereja_id' => $gerejaTujuanId,
            ]);

            if (!is_null($gerejaTujuanId)) {
                $jabatanAktif = JabatanPendeta::where('pendeta_id', $pendeta->id)
                    ->whereNull('tanggal_akhir')
                    ->orderByDesc('tanggal_awal')
                    ->first();
                if ($jabatanAktif && $jabatanAktif->gereja_id != $gerejaTujuanId) {
                    $jabatanAktif->update(['tanggal_akhir' => $effectiveDate]);
                }
            }
        });

        return redirect()->route('superadmin.pendeta.index')->with('success', 'Perpindahan pendeta berhasil diproses.');
    }

    private function generateUniqueIdAkun()
    {
        do {
            $number = rand(1, 99999); // Generate random number between 1 and 99999
            $id_akun = 'PD' . str_pad($number, 5, '0', STR_PAD_LEFT); // Format as PD00001
        } while (Pendeta::where('id_akun', $id_akun)->exists()); // Check for uniqueness

        return $id_akun;
    }
}
