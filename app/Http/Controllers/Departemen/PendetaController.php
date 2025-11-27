<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use App\Models\Pendeta;
use App\Models\Region;
use App\Models\Departemen;
use App\Models\Gereja;
use App\Models\Perlawatan;
use App\Models\Penjadwalan;
use App\Models\Anggota;
// Jabatan management by SuperAdmin only; remove here
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PendetaController extends Controller
{
    public function index()
    {
        $userRegionId = Auth::user()->region_id;
        $pendetas = Pendeta::with([
                'region', 'departemen', 'gereja',
                'jabatanHistories' => function ($q) {
                    $q->whereNull('tanggal_akhir')->orderByDesc('tanggal_awal');
                },
                'jabatanHistories.jabatan'
            ])
            ->where('region_id', $userRegionId)
            ->get();
        return view('departemen.pendeta.index', compact('pendetas'));
    }

    public function create()
    {
        $userRegionId = Auth::user()->region_id;
        $regions = Region::where('id', $userRegionId)->get();
        $departemens = Departemen::where('region_id', $userRegionId)->get();
        return view('departemen.pendeta.create', compact('regions', 'departemens'));
    }

    public function store(Request $request)
    {
        $userRegionId = Auth::user()->region_id;
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
            'nama_pendeta' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'region_id' => 'required|exists:regions,id|in:' . $userRegionId,
            'departemen_id' => 'required|exists:departemens,id',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi departemen_id dan gereja_id di region user
        if ($request->departemen_id && !Departemen::where('region_id', $userRegionId)->where('id', $request->departemen_id)->exists()) {
            return redirect()->back()->withErrors(['departemen_id' => 'Departemen tidak valid untuk region Anda.'])->withInput();
        }
        if ($request->gereja_id && !Gereja::where('region_id', $userRegionId)->where('id', $request->gereja_id)->exists()) {
            return redirect()->back()->withErrors(['gereja_id' => 'Gereja tidak valid untuk region Anda.'])->withInput();
        }

        // Generate unique id_akun
        $id_akun = $this->generateUniqueIdAkun();

        $data = $request->all();
        $data['id_akun'] = $id_akun;
        $data['password'] = Hash::make($request->password);
        Pendeta::create($data);
        return redirect()->route('departemen.pendeta.index')->with('success', 'Pendeta berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $userRegionId = Auth::user()->region_id;
        $pendeta = Pendeta::where('region_id', $userRegionId)->findOrFail($id);
        $regions = Region::where('id', $userRegionId)->get();
        $departemens = Departemen::where('region_id', $userRegionId)->get();
        $gerejas = Gereja::where('region_id', $userRegionId)->get();
        return view('departemen.pendeta.edit', compact('pendeta', 'regions', 'departemens', 'gerejas'));
    }

    public function update(Request $request, $id)
    {
        $userRegionId = Auth::user()->region_id;
        $pendeta = Pendeta::where('region_id', $userRegionId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id_akun' => 'required|string|max:50|unique:pendetas,id_akun,' . $id,
            'password' => 'nullable|string|min:6',
            'nama_pendeta' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'region_id' => 'required|exists:regions,id|in:' . $userRegionId,
            'departemen_id' => 'required|exists:departemens,id',
            'gereja_id' => 'nullable|exists:gerejas,id',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi departemen_id dan gereja_id di region user
        if ($request->departemen_id && !Departemen::where('region_id', $userRegionId)->where('id', $request->departemen_id)->exists()) {
            return redirect()->back()->withErrors(['departemen_id' => 'Departemen tidak valid untuk region Anda.'])->withInput();
        }
        if ($request->gereja_id && !Gereja::where('region_id', $userRegionId)->where('id', $request->gereja_id)->exists()) {
            return redirect()->back()->withErrors(['gereja_id' => 'Gereja tidak valid untuk region Anda.'])->withInput();
        }

        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }
        $pendeta->update($data);


        return redirect()->route('departemen.pendeta.index')->with('success', 'Pendeta berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $userRegionId = Auth::user()->region_id;
        $pendeta = Pendeta::where('region_id', $userRegionId)->findOrFail($id);
        $pendeta->delete();
        return redirect()->route('departemen.pendeta.index')->with('success', 'Pendeta berhasil dihapus.');
    }

    public function perlawatan($id)
    {
        $userRegionId = Auth::user()->region_id;
        $pendeta = Pendeta::where('region_id', $userRegionId)->findOrFail($id);
        $perlawatans = Perlawatan::where('pendeta_id', $pendeta->id)
            ->with(['anggota' => function ($query) use ($userRegionId) {
                $query->whereHas('gereja', function ($q) use ($userRegionId) {
                    $q->where('region_id', $userRegionId);
                });
            }])
            ->get();
        $anggotas = Anggota::whereHas('gereja', function ($query) use ($userRegionId) {
            $query->where('region_id', $userRegionId);
        })->get();
        return view('departemen.pendeta.perlawatan', compact('pendeta', 'perlawatans', 'anggotas'));
    }

    public function storePerlawatan(Request $request, $id)
    {
        $userRegionId = Auth::user()->region_id;
        $pendeta = Pendeta::where('region_id', $userRegionId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string',
            'gambar_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi anggota_id di region user
        if ($request->anggota_id && !Anggota::whereHas('gereja', function ($query) use ($userRegionId) {
            $query->where('region_id', $userRegionId);
        })->where('id', $request->anggota_id)->exists()) {
            return redirect()->back()->withErrors(['anggota_id' => 'Anggota tidak valid untuk region Anda.'])->withInput();
        }

        $data = $request->all();
        $data['pendeta_id'] = $pendeta->id;
        if ($request->hasFile('gambar_bukti')) {
            // Updated to store in public/gambar_bukti
            $data['gambar_bukti'] = $request->file('gambar_bukti')->store('gambar_bukti', 'public');
        }
        Perlawatan::create($data);
        return redirect()->route('departemen.pendeta.perlawatan', $pendeta)->with('success', 'Perlawatan berhasil ditambahkan.');
    }

    public function penjadwalan($id)
    {
        $userRegionId = Auth::user()->region_id;
        $pendeta = Pendeta::where('region_id', $userRegionId)->findOrFail($id);
        $penjadwalans = Penjadwalan::where('pendeta_id', $pendeta->id)->get();
        return view('departemen.pendeta.penjadwalan', compact('pendeta', 'penjadwalans'));
    }

    public function storePenjadwalan(Request $request, $id)
    {
        $userRegionId = Auth::user()->region_id;
        $pendeta = Pendeta::where('region_id', $userRegionId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'judul_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'gambar_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lokasi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['pendeta_id'] = $pendeta->id;
        if ($request->hasFile('gambar_bukti')) {
            // Updated to store in public/gambar_bukti_penjadwalan
            $data['gambar_bukti'] = $request->file('gambar_bukti')->store('gambar_bukti_penjadwalan', 'public');
        }
        Penjadwalan::create($data);
        return redirect()->route('departemen.pendeta.penjadwalan', $pendeta)->with('success', 'Penjadwalan berhasil ditambahkan.');
    }

    public function detail($id)
    {
        $userRegionId = Auth::user()->region_id;
        $pendeta = Pendeta::where('id', $id)
            ->where('region_id', $userRegionId)
            ->with([
                'region', 'departemen', 'gereja',
                'jabatanHistories' => function ($q) {
                    $q->orderByDesc('tanggal_awal');
                },
                'jabatanHistories.jabatan',
                'jabatanHistories.gereja',
                'regionHistories' => function ($q) {
                    $q->orderByDesc('tanggal_awal');
                },
                'regionHistories.region'
            ])->firstOrFail();
        $perlawatans = Perlawatan::where('pendeta_id', $pendeta->id)->with('anggota')->get();
        $penjadwalans = Penjadwalan::where('pendeta_id', $pendeta->id)->get();
        return view('departemen.pendeta.detail', compact('pendeta', 'perlawatans', 'penjadwalans'));
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
