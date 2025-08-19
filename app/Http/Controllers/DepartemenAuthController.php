<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartemenAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.departemen-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('id_akun', 'password');

        if (Auth::guard('departemen')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/departemen/dashboard');
        }

        return back()->withErrors([
            'id_akun' => 'ID Akun atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('departemen')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/departemen/login');
    }
}