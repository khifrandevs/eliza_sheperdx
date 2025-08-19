<?php

namespace App\Http\Controllers\api;

use App\Models\Pendeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class PendetaController extends Controller
{
    public function __construct()
    {


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $pendetas = Pendeta::with(['region', 'departemen', 'gereja.region'])->get();
            
            $data = $pendetas->map(function ($pendeta) {
                return [
                    'id' => $pendeta->id,
                    'id_akun' => $pendeta->id_akun,
                    'role' => 'pendeta',
                    'nama' => $pendeta->nama_pendeta,
                    'no_telp' => $pendeta->no_telp,
                    'alamat' => $pendeta->alamat,
                    'region' => $pendeta->region ? [
                        'id' => $pendeta->region->id,
                        'kode_region' => $pendeta->region->kode_region,
                        'nama_region' => $pendeta->region->nama_region,
                        'deskripsi' => $pendeta->region->deskripsi,
                    ] : null,
                    'departemen' => $pendeta->departemen ? [
                        'id' => $pendeta->departemen->id,
                        'id_akun' => $pendeta->departemen->id_akun,
                        'nama_departemen' => $pendeta->departemen->nama_departemen, // Diperbaiki dari id ke nama_departemen
                        'deskripsi' => $pendeta->departemen->deskripsi,
                        'nama_region' => $pendeta->departemen->region->nama_region ?? null,
                    ] : null,
                    'gereja' => $pendeta->gereja ? [
                        'id' => $pendeta->gereja->id,
                        'nama_gereja' => $pendeta->gereja->nama_gereja,
                        'alamat' => $pendeta->gereja->alamat,
                        'nama_region' => $pendeta->gereja->region->nama_region ?? null,
                    ] : null,
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'List of pendeta',
                'data' => $data,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve pendeta list',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}