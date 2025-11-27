<?php

namespace App\Http\Controllers\api;

use App\Models\Penjadwalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            // Get the authenticated pendeta
            $pendeta = Auth::user();

            // Get penjadwalan only for the logged-in pendeta
            $penjadwalans = Penjadwalan::with('pendeta')
                ->where('pendeta_id', $pendeta->id)
                ->get();

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

    /**w
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            // Get the authenticated pendeta
            $pendeta = Auth::user();

            // Get penjadwalan only for the logged-in pendeta
            $penjadwalan = Penjadwalan::with('pendeta')
                ->where('pendeta_id', $pendeta->id)
                ->findOrFail($id);

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
            Log::info('Update method called for ID:', ['id' => $id]);

            // Get the authenticated pendeta
            $pendeta = Auth::user();

            // Get penjadwalan only for the logged-in pendeta
            $penjadwalan = Penjadwalan::where('pendeta_id', $pendeta->id)
                ->findOrFail($id);

            // Get all input data
            $inputData = $request->all();
            Log::info('Input data:', $inputData);

            // Validate the data
            $validator = Validator::make($inputData, [
                'pendeta_id' => 'sometimes|exists:pendetas,id',
                'judul_kegiatan' => 'sometimes|string|max:255',
                'deskripsi' => 'sometimes|nullable|string',
                'tanggal_mulai' => 'sometimes|date',
                'tanggal_selesai' => 'sometimes|date|after_or_equal:tanggal_mulai',
                'gambar_bukti' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'lokasi' => 'sometimes|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Prepare update data
            $updateData = [];
            if (isset($inputData['pendeta_id'])) $updateData['pendeta_id'] = $inputData['pendeta_id'];
            if (isset($inputData['judul_kegiatan'])) $updateData['judul_kegiatan'] = $inputData['judul_kegiatan'];
            if (isset($inputData['deskripsi'])) $updateData['deskripsi'] = $inputData['deskripsi'];
            if (isset($inputData['tanggal_mulai'])) $updateData['tanggal_mulai'] = $inputData['tanggal_mulai'];
            if (isset($inputData['tanggal_selesai'])) $updateData['tanggal_selesai'] = $inputData['tanggal_selesai'];
            if (isset($inputData['lokasi'])) $updateData['lokasi'] = $inputData['lokasi'];

            // Handle file upload
           if ($request->hasFile('gambar_bukti')) {
                // Delete old file if exists
                $oldFilePath = base_path('../public_html/gambar_bukti_penjadwalan/' . $penjadwalan->gambar_bukti);
                if ($penjadwalan->gambar_bukti && file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            
                $file = $request->file('gambar_bukti');
                $filename = time() . '_' . $file->getClientOriginalName();
            
                // Save directly to public_html
                $file->move(base_path('../public_html/gambar_bukti_penjadwalan'), $filename);
            
                $updateData['gambar_bukti'] = $filename;
            }


            Log::info('Update data:', $updateData);

            $penjadwalan->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'Penjadwalan updated successfully',
                'data' => $penjadwalan->fresh()->load('pendeta'),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Update error:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
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
            // Get the authenticated pendeta
            $pendeta = Auth::user();

            // Get penjadwalan only for the logged-in pendeta
            $penjadwalan = Penjadwalan::where('pendeta_id', $pendeta->id)
                ->findOrFail($id);

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

    /**
     * Parse multipart form data for PUT requests
     */
    private function parseMultipartData(Request $request)
    {
        $data = [];

        // Get the raw input
        $input = $request->getContent();

        // Parse the multipart boundary
        $boundary = null;
        if (preg_match('/boundary=(.*)$/', $request->header('Content-Type'), $matches)) {
            $boundary = $matches[1];
        }

        if ($boundary) {
            // Split the content by boundary
            $parts = array_slice(explode('--' . $boundary, $input), 1);

            foreach ($parts as $part) {
                // Skip the last part (boundary end)
                if ($part == "--\r\n" || $part == "--") {
                    continue;
                }

                // Parse the part
                $part = ltrim($part, "\r\n");
                list($rawHeaders, $body) = explode("\r\n\r\n", $part, 2);

                // Parse headers
                $headers = [];
                foreach (explode("\r\n", $rawHeaders) as $header) {
                    if (preg_match('/^([^:]+):\s*(.+)$/', $header, $matches)) {
                        $headers[strtolower($matches[1])] = $matches[2];
                    }
                }

                // Get the field name
                if (preg_match('/name="([^"]+)"/', $headers['content-disposition'] ?? '', $matches)) {
                    $name = $matches[1];
                    $data[$name] = trim($body);
                }
            }
        }

        return $data;
    }
}
