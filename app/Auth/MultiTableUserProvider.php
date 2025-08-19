<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use App\Models\SuperAdmin;
use App\Models\Departemen;
use App\Models\Pendeta;

class MultiTableUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        $idAkun = $credentials['id_akun'];

        // Cari di table super_admins
        $user = SuperAdmin::where('id_akun', $idAkun)->first();
        if ($user) {
            $user->role = 'superadmin';
            return $user;
        }

        // Cari di table departemens
        $user = Departemen::where('id_akun', $idAkun)->first();
        if ($user) {
            $user->role = 'departemen';
            return $user;
        }

        // Cari di table pendetas
        $user = Pendeta::where('id_akun', $idAkun)->first();
        if ($user) {
            $user->role = 'pendeta';
            return $user;
        }

        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return Hash::check($credentials['password'], $user->password);
    }
}