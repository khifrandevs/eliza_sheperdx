<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuperAdmin;
use App\Models\Departemen;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('id_akun', 'password');

        // Cek di table super_admins
        $superadmin = SuperAdmin::where('id_akun', $credentials['id_akun'])->first();
        if ($superadmin && Hash::check($credentials['password'], $superadmin->password)) {
            Auth::guard('superadmin')->login($superadmin);
            $request->session()->regenerate();
            return redirect()->intended('/superadmin/dashboard');
        }

        // Cek di table departemens
        $departemen = Departemen::where('id_akun', $credentials['id_akun'])->first();
        if ($departemen && Hash::check($credentials['password'], $departemen->password)) {
            Auth::guard('departemen')->login($departemen);
            $request->session()->regenerate();
            return redirect()->intended('/departemen/dashboard');
        }

        return back()->withErrors([
            'id_akun' => 'ID Akun atau password salah.',
        ])->onlyInput('id_akun');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('superadmin')->check()) {
            Auth::guard('superadmin')->logout();
        } elseif (Auth::guard('departemen')->check()) {
            Auth::guard('departemen')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}