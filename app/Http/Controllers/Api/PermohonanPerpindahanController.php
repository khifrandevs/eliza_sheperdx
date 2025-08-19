<?php

namespace App\Http\Controllers\api;

use App\Models\PermohonanPerpindahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class PermohonanPerpindahanController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $permohonans = PermohonanPerpindahan::with(['pendeta', 'regionAsal', 'regionTujuan'])->get();
            
            $data = $permohonans->map(function ($permohonan) {
                return [
                    'id' => $permohonan->id,
                    'pendeta' => $permohonan->pendeta ? [
                        'id' => $permohonan->pendeta->id,
                        'nama' => $permohonan->pendeta->nama_pendeta,
                    ] : null,
                    'region_asal' => $permohonan->regionAsal ? [
                        'id' => $permohonan->regionAsal->id,
                        'nama' => $permohonan->regionAsal->nama, // Asumsi field nama ada di model Region
                    ] : null,
                    'region_tujuan' => $permohonan->regionTujuan ? [
                        'id' => $permohonan->regionTujuan->id,
                        'nama' => $permohonan->regionTujuan->nama, // Asumsi field nama ada di model Region
                    ] : null,
                    'alasan' => $permohonan->alasan,
                    'status' => $permohonan->status,
                    'tanggal_permohonan' => $permohonan->tanggal_permohonan->format('Y-m-d'),
                    'created_at' => $permohonan->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $permohonan->updated_at->format('Y-m-d H:i:s'),
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'List of permohonan perpindahan',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve permohonan perpindahan list',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $permohonan = PermohonanPerpindahan::with(['pendeta', 'regionAsal', 'regionTujuan'])->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Permohonan perpindahan details',
                'data' => [
                    'id' => $permohonan->id,
                    'pendeta' => $permohonan->pendeta ? [
                        'id' => $permohonan->pendeta->id,
                        'nama' => $permohonan->pendeta->nama_pendeta,
                    ] : null,
                    'region_asal' => $permohonan->regionAsal ? [
                        'id' => $permohonan->regionAsal->id,
                        'nama' => $permohonan->regionAsal->nama,
                    ] : null,
                    'region_tujuan' => $permohonan->regionTujuan ? [
                        'id' => $permohonan->regionTujuan->id,
                        'nama' => $permohonan->regionTujuan->nama,
                    ] : null,
                    'alasan' => $permohonan->alasan,
                    'status' => $permohonan->status,
                    'tanggal_permohonan' => $permohonan->tanggal_permohonan->format('Y-m-d'),
                    'created_at' => $permohonan->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $permohonan->updated_at->format('Y-m-d H:i:s'),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permohonan perpindahan not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pendeta_id' => 'required|exists:pendetas,id',
                'region_asal_id' => 'required|exists:regions,id',
                'region_tujuan_id' => 'required|exists:regions,id|different:region_asal_id',
                'alasan' => 'required|string',
                'status' => 'sometimes|in:pending,disetujui,ditolak',
                'tanggal_permohonan' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->all();
            // Set default status to 'pending' if not provided
            $data['status'] = $request->input('status', 'pending');

            $permohonan = PermohonanPerpindahan::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Permohonan perpindahan created successfully',
                'data' => $permohonan->load(['pendeta', 'regionAsal', 'regionTujuan']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create permohonan perpindahan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}