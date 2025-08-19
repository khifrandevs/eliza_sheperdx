<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperAdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.superadmin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('id_akun', 'password');

        if (Auth::guard('superadmin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/superadmin/dashboard');
        }

        return back()->withErrors([
            'id_akun' => 'ID Akun atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('superadmin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/superadmin/login');
    }
}