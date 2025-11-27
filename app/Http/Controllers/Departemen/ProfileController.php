<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('departemen.profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        /** @var \App\Models\Departemen $user */
        $user = Auth::user();
        $user->nama_departemen = $request->nama_departemen;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('departemen.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
