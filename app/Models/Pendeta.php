<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Pendeta extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'pendetas';
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Specify id_akun as the authentication identifier
    public function getAuthIdentifierName()
    {
        return 'id_akun';
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'guard' => 'pendeta',
            'role' => $this->role ?? 'pendeta',
        ];
    }
}