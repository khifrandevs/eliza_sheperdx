<?php

namespace App\Http\Controllers\Api;

use App\Models\Pendeta;
use App\Models\PermohonanPerpindahan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct()
    {
        // Middleware is applied in routes
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_akun' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('id_akun', 'password');

        try {
            // Check Pendeta
            $pendeta = Pendeta::where('id_akun', $credentials['id_akun'])->first();
            if ($pendeta && Hash::check($credentials['password'], $pendeta->password)) {
                $token = JWTAuth::fromUser($pendeta);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'user' => [
                            'id' => $pendeta->id,
                            'id_akun' => $pendeta->id_akun,
                            'role' => 'pendeta',
                            'nama' => $pendeta->nama_pendeta,
                        ],
                        'token' => $token
                    ]
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'ID Akun or password is incorrect'
            ], 401);

        } catch (JWTException $e) {
            Log::error('Login Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Could not create token: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            Log::error('Unexpected Login Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error: ' . $e->getMessage()
            ], 500);
        }
    }

        public function verifyToken(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                Log::warning('Token not found in request');
                return response()->json([
                    'success' => false,
                    'message' => 'Token not provided'
                ], 401);
            }

            $user = JWTAuth::authenticate($token);
            if (!$user) {
                Log::warning('Invalid or expired token');
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired token'
                ], 401);
            }

            Log::info('Token verified for user: ' . $user->nama_pendeta);
            return response()->json([
                'success' => true,
                'message' => 'Token is valid',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'id_akun' => $user->id_akun,
                        'role' => 'pendeta',
                        'nama' => $user->nama_pendeta,
                    ]
                ]
            ], 200);
        } catch (JWTException $e) {
            Log::error('Token Verification Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Token verification failed: ' . $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            Log::error('Unexpected Token Verification Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function me(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'id_akun' => $user->id_akun,
                        'role' => 'pendeta',
                        'nama' => $user->nama_pendeta,
                        'no_telp' => $user->no_telp,
                        'alamat' => $user->alamat,
                        'region' => $user->region ? [
                            'id' => $user->region->id,
                            'kode_region' => $user->region->kode_region,
                            'nama_region' => $user->region->nama_region,
                            'deskripsi' => $user->region->deskripsi,
                        ] : null,
                        'departemen' => $user->departemen ? [
                            'id' => $user->departemen->id,
                            'id_akun' => $user->departemen->id_akun,
                            'nama_departemen' => $user->departemen->id,
                            'deskripsi' => $user->departemen->deskripsi,
                            'nama_region' => $user->departemen->region->nama_region,
                        ] : null,
                        'gereja' => $user->gereja ? [
                            'id' => $user->gereja->id,
                            'nama_gereja' => $user->gereja->nama_gereja,
                            'alamat' => $user->gereja->alamat,
                            'nama_region' => $user->gereja->region->nama_region,
                        ] : null,
                    ]
                ]
            ], 200);
        } catch (JWTException $e) {
            Log::error('Me Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid'
            ], 401);
        } catch (\Exception $e) {
            Log::error('Unexpected Me Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Invalidate the current token
            JWTAuth::parseToken()->invalidate();

            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ], 200);
        } catch (JWTException $e) {
            Log::error('Logout Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            Log::error('Unexpected Logout Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $validator = Validator::make($request->all(), [
                'nama_pendeta' => 'sometimes|string|max:255',
                'no_telp' => 'sometimes|string|max:255',
                'alamat' => 'sometimes|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $pendeta = Pendeta::find($user->id);
            if (!$pendeta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendeta not found'
                ], 404);
            }

            // Update fields if provided
            if ($request->has('nama_pendeta')) {
                $pendeta->nama_pendeta = $request->nama_pendeta;
            }

            if ($request->has('no_telp')) {
                $pendeta->no_telp = $request->no_telp;
            }

            if ($request->has('alamat')) {
                $pendeta->alamat = $request->alamat;
            }

            $pendeta->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'user' => [
                        'id' => $pendeta->id,
                        'id_akun' => $pendeta->id_akun,
                        'role' => 'pendeta',
                        'nama_pendeta' => $pendeta->nama_pendeta,
                        'no_telp' => $pendeta->no_telp,
                        'alamat' => $pendeta->alamat,
                    ]
                ]
            ], 200);

        } catch (JWTException $e) {
            Log::error('Update Profile Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid'
            ], 401);
        } catch (\Exception $e) {
            Log::error('Unexpected Update Profile Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $validator = Validator::make($request->all(), [
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:6|confirmed',
                'new_password_confirmation' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $pendeta = Pendeta::find($user->id);
            if (!$pendeta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendeta not found'
                ], 404);
            }

            // Verify current password
            if (!Hash::check($request->current_password, $pendeta->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 400);
            }

            // Check if new password is different from current password
            if (Hash::check($request->new_password, $pendeta->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'New password must be different from current password'
                ], 400);
            }

            // Update password
            $pendeta->password = Hash::make($request->new_password);
            $pendeta->save();

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ], 200);

        } catch (JWTException $e) {
            Log::error('Change Password Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid'
            ], 401);
        } catch (\Exception $e) {
            Log::error('Unexpected Change Password Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function permohonan(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $validator = Validator::make($request->all(), [
                'region_asal_id' => 'required|exists:regions,id',
                'region_tujuan_id' => 'required|exists:regions,id|different:region_asal_id',
                'alasan' => 'required|string|min:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $pendeta = Pendeta::find($user->id);
            if (!$pendeta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendeta not found'
                ], 404);
            }

            // Check if there's already a pending request
            $existingRequest = PermohonanPerpindahan::where('pendeta_id', $pendeta->id)
                ->where('status', 'pending')
                ->first();

            if ($existingRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have a pending transfer request'
                ], 400);
            }

            // Check if the last permohonan was not approved (pending or ditolak)
            $lastPermohonan = PermohonanPerpindahan::where('pendeta_id', $pendeta->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($lastPermohonan && $lastPermohonan->status !== 'disetujui') {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot create a new request until your last request is approved'
                ], 400);
            }

            // Create new permohonan
            $permohonan = PermohonanPerpindahan::create([
                'pendeta_id' => $pendeta->id,
                'region_asal_id' => $request->region_asal_id,
                'region_tujuan_id' => $request->region_tujuan_id,
                'alasan' => $request->alasan,
                'status' => 'pending',
                'tanggal_permohonan' => now()->toDateString(),
            ]);

            // Load relationships for response
            $permohonan->load(['regionAsal', 'regionTujuan']);

            return response()->json([
                'success' => true,
                'message' => 'Transfer request submitted successfully',
                'data' => [
                    'permohonan' => [
                        'id' => $permohonan->id,
                        'pendeta_id' => $permohonan->pendeta_id,
                        'region_asal' => [
                            'id' => $permohonan->regionAsal->id,
                            'kode_region' => $permohonan->regionAsal->kode_region,
                            'nama_region' => $permohonan->regionAsal->nama_region,
                        ],
                        'region_tujuan' => [
                            'id' => $permohonan->regionTujuan->id,
                            'kode_region' => $permohonan->regionTujuan->kode_region,
                            'nama_region' => $permohonan->regionTujuan->nama_region,
                        ],
                        'alasan' => $permohonan->alasan,
                        'status' => $permohonan->status,
                        'tanggal_permohonan' => $permohonan->tanggal_permohonan,
                        'created_at' => $permohonan->created_at,
                    ]
                ]
            ], 201);

        } catch (JWTException $e) {
            Log::error('Permohonan Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid'
            ], 401);
        } catch (\Exception $e) {
            Log::error('Unexpected Permohonan Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function listPermohonan(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $pendeta = Pendeta::find($user->id);
            if (!$pendeta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendeta not found'
                ], 404);
            }

            // Get all permohonan for this user, ordered by latest first
            $permohonanList = PermohonanPerpindahan::where('pendeta_id', $pendeta->id)
                ->with(['regionAsal', 'regionTujuan'])
                ->orderBy('created_at', 'desc')
                ->get();

            $formattedPermohonan = $permohonanList->map(function ($permohonan) {
                return [
                    'id' => $permohonan->id,
                    'pendeta_id' => $permohonan->pendeta_id,
                    'region_asal' => [
                        'id' => $permohonan->regionAsal->id,
                        'kode_region' => $permohonan->regionAsal->kode_region,
                        'nama_region' => $permohonan->regionAsal->nama_region,
                    ],
                    'region_tujuan' => [
                        'id' => $permohonan->regionTujuan->id,
                        'kode_region' => $permohonan->regionTujuan->kode_region,
                        'nama_region' => $permohonan->regionTujuan->nama_region,
                    ],
                    'alasan' => $permohonan->alasan,
                    'status' => $permohonan->status,
                    'tanggal_permohonan' => $permohonan->tanggal_permohonan,
                    'created_at' => $permohonan->created_at,
                    'updated_at' => $permohonan->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'permohonan_list' => $formattedPermohonan,
                    'total_count' => $permohonanList->count(),
                    'can_create_new' => $this->canCreateNewPermohonan($pendeta->id)
                ]
            ], 200);

        } catch (JWTException $e) {
            Log::error('List Permohonan Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid'
            ], 401);
        } catch (\Exception $e) {
            Log::error('Unexpected List Permohonan Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function canCreateNewPermohonan($pendetaId)
    {
        // Check if there's already a pending request
        $pendingRequest = PermohonanPerpindahan::where('pendeta_id', $pendetaId)
            ->where('status', 'pending')
            ->exists();

        if ($pendingRequest) {
            return false;
        }

        // Check if the last permohonan was not approved
        $lastPermohonan = PermohonanPerpindahan::where('pendeta_id', $pendetaId)
            ->orderBy('created_at', 'desc')
            ->first();

        // If no previous permohonan or last one was approved, can create new
        return !$lastPermohonan || $lastPermohonan->status === 'disetujui';
    }
}
