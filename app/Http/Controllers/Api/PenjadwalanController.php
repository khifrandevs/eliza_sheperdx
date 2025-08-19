<?php

namespace App\Http\Controllers\api;

use App\Models\Penjadwalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class PenjadwalanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $penjadwalans = Penjadwalan::with('pendeta')->get();
            
            $data = $penjadwalans->map(function ($penjadwalan) {
                return [
                    'id' => $penjadwalan->id,
                    'pendeta' => $penjadwalan->pendeta ? [
                        'id' => $penjadwalan->pendeta->id,
                        'nama' => $penjadwalan->pendeta->nama_pendeta,
                    ] : null,
                    'judul_kegiatan' => $penjadwalan->judul_kegiatan,
                    'deskripsi' => $penjadwalan->deskripsi,
                    'tanggal_mulai' => $penjadwalan->tanggal_mulai->format('Y-m-d H:i:s'),
                    'tanggal_selesai' => $penjadwalan->tanggal_selesai->format('Y-m-d H:i:s'),
                    'gambar_bukti' => $penjadwalan->gambar_bukti ? url('gambar_bukti_penjadwalan/' . $penjadwalan->gambar_bukti) : null,
                    'lokasi' => $penjadwalan->lokasi,
                    'created_at' => $penjadwalan->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $penjadwalan->updated_at->format('Y-m-d H:i:s'),
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'List of penjadwalan',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve penjadwalan list',
                'error' => $e->getMessage(),
            ], 500);
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
                'judul_kegiatan' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'gambar_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
                'lokasi' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->all();

            // Handle file upload
            if ($request->hasFile('gambar_bukti')) {
                $file = $request->file('gambar_bukti');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('gambar_bukti_penjadwalan'), $filename);
                $data['gambar_bukti'] = $filename;
            }

            $penjadwalan = Penjadwalan::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Penjadwalan created successfully',
                'data' => $penjadwalan->load('pendeta'),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create penjadwalan',
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
            $penjadwalan = Penjadwalan::with('pendeta')->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Penjadwalan details',
                'data' => [
                    'id' => $penjadwalan->id,
                    'pendeta' => $penjadwalan->pendeta ? [
                        'id' => $penjadwalan->pendeta->id,
                        'nama' => $penjadwalan->pendeta->nama_pendeta,
                    ] : null,
                    'judul_kegiatan' => $penjadwalan->judul_kegiatan,
                    'deskripsi' => $penjadwalan->deskripsi,
                    'tanggal_mulai' => $penjadwalan->tanggal_mulai->format('Y-m-d H:i:s'),
                    'tanggal_selesai' => $penjadwalan->tanggal_selesai->format('Y-m-d H:i:s'),
                    'gambar_bukti' => $penjadwalan->gambar_bukti ? url('gambar_bukti_penjadwalan/' . $penjadwalan->gambar_bukti) : null,
                    'lokasi' => $penjadwalan->lokasi,
                    'created_at' => $penjadwalan->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $penjadwalan->updated_at->format('Y-m-d H:i:s'),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Penjadwalan not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $penjadwalan = Penjadwalan::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'pendeta_id' => 'sometimes|exists:pendetas,id',
                'judul_kegiatan' => 'sometimes|string|max:255',
                'deskripsi' => 'nullable|string',
                'tanggal_mulai' => 'sometimes|date',
                'tanggal_selesai' => 'sometimes|date|after_or_equal:tanggal_mulai',
                'gambar_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
                'lokasi' => 'sometimes|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->all();

            // Handle file upload
            if ($request->hasFile('gambar_bukti')) {
                // Delete old file if exists
                if ($penjadwalan->gambar_bukti && file_exists(public_path('gambar_bukti_penjadwalan/' . $penjadwalan->gambar_bukti))) {
                    unlink(public_path('gambar_bukti_penjadwalan/' . $penjadwalan->gambar_bukti));
                }
                
                $file = $request->file('gambar_bukti');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('gambar_bukti_penjadwalan'), $filename);
                $data['gambar_bukti'] = $filename;
            }

            $penjadwalan->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Penjadwalan updated successfully',
                'data' => $penjadwalan->load('pendeta'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update penjadwalan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $penjadwalan = Penjadwalan::findOrFail($id);

            // Delete file if exists
            if ($penjadwalan->gambar_bukti && file_exists(public_path('gambar_bukti_penjadwalan/' . $penjadwalan->gambar_bukti))) {
                unlink(public_path('gambar_bukti_penjadwalan/' . $penjadwalan->gambar_bukti));
            }

            $penjadwalan->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Penjadwalan deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete penjadwalan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}