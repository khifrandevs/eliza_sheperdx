<?php

namespace App\Http\Controllers\api;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
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
        $anggotas = Anggota::with('gereja')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'List of Anggota',
            'data' => $anggotas,
            'region' => $anggotas->region
        ], 200);
    }
}