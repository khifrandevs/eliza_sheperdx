<?php

namespace App\Http\Controllers\api;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class RegionController extends Controller
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
        $regions = Region::all();
        return response()->json([
            'status' => 'success',
            'message' => 'List of Region',
            'data' => $regions
        ], 200);
    }
}
