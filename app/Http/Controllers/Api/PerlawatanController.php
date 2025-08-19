<?php

namespace App\Http\Controllers\api;

use App\Models\Perlawatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class PerlawatanController extends Controller
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
            $perlawatans = Perlawatan::with(['pendeta', 'anggota'])->get();
            
            $data = $perlawatans->map(function ($perlawatan) {
                return [
                    'id' => $perlawatan->id,
                    'pendeta' => $perlawatan->pendeta ? [
                        'id' => $perlawatan->pendeta->id,
                        'nama' => $perlawatan->pendeta->nama_pendeta,
                    ] : null,
                    'anggota' => $perlawatan->anggota ? [
                        'id' => $perlawatan->anggota->id,
                        'nama' => $perlawatan->anggota->nama,
                    ] : null,
                    'tanggal' => $perlawatan->tanggal->format('Y-m-d'),
                    'lokasi' => $perlawatan->lokasi,
                    'gambar_bukti' => $perlawatan->gambar_bukti ? url('gambar_bukti/' . $perlawatan->gambar_bukti) : null,
                    'catatan' => $perlawatan->catatan,
                    'created_at' => $perlawatan->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $perlawatan->updated_at->format('Y-m-d H:i:s'),
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'List of perlawatan',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve perlawatan list',
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
                'anggota_id' => 'required|exists:anggotas,id',
                'tanggal' => 'required|date',
                'lokasi' => 'required|string|max:255',
                'gambar_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
                'catatan' => 'nullable|string',
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
                $file->move(public_path('gambar_bukti'), $filename);
                $data['gambar_bukti'] = $filename;
            }

            $perlawatan = Perlawatan::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Perlawatan created successfully',
                'data' => $perlawatan->load(['pendeta', 'anggota']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create perlawatan',
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
            $perlawatan = Perlawatan::with(['pendeta', 'anggota'])->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Perlawatan details',
                'data' => [
                    'id' => $perlawatan->id,
                    'pendeta' => $perlawatan->pendeta ? [
                        'id' => $perlawatan->pendeta->id,
                        'nama' => $perlawatan->pendeta->nama_pendeta,
                    ] : null,
                    'anggota' => $perlawatan->anggota ? [
                        'id' => $perlawatan->anggota->id,
                        'nama' => $perlawatan->anggota->nama,
                    ] : null,
                    'tanggal' => $perlawatan->tanggal->format('Y-m-d'),
                    'lokasi' => $perlawatan->lokasi,
                    'gambar_bukti' => $perlawatan->gambar_bukti ? url('gambar_bukti/' . $perlawatan->gambar_bukti) : null,
                    'catatan' => $perlawatan->catatan,
                    'created_at' => $perlawatan->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $perlawatan->updated_at->format('Y-m-d H:i:s'),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Perlawatan not found',
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
            $perlawatan = Perlawatan::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'pendeta_id' => 'sometimes|exists:pendetas,id',
                'anggota_id' => 'sometimes|exists:anggotas,id',
                'tanggal' => 'sometimes|date',
                'lokasi' => 'sometimes|string|max:255',
                'gambar_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
                'catatan' => 'nullable|string',
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
                if ($perlawatan->gambar_bukti && file_exists(public_path('gambar_bukti/' . $perlawatan->gambar_bukti))) {
                    unlink(public_path('gambar_bukti/' . $perlawatan->gambar_bukti));
                }
                
                $file = $request->file('gambar_bukti');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('gambar_bukti'), $filename);
                $data['gambar_bukti'] = $filename;
            }

            $perlawatan->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Perlawatan updated successfully',
                'data' => $perlawatan->load(['pendeta', 'anggota']),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update perlawatan',
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
            $perlawatan = Perlawatan::findOrFail($id);

            // Delete file if exists
            if ($perlawatan->gambar_bukti && file_exists(public_path('gambar_bukti/' . $perlawatan->gambar_bukti))) {
                unlink(public_path('gambar_bukti/' . $perlawatan->gambar_bukti));
            }

            $perlawatan->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Perlawatan deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete perlawatan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}