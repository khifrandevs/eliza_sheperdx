<?php

namespace App\Http\Controllers\api;

use App\Models\Pendeta;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['logout']);
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
                $token = JWTAuth::fromUser($pendeta, ['guard' => 'pendeta']);
                
                return response()->json([
                    'success' => true,
                    'data' => [
                        'user' => [
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
}