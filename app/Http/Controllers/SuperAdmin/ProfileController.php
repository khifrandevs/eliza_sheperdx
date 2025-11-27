<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('superadmin.profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        /** @var \App\Models\SuperAdmin $user */
        $user = Auth::user();
        $user->nama_admin = $request->nama_admin;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('superadmin.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
