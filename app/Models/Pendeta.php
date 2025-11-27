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
        'id' => 'integer',              // bigint(20) unsigned, primary key
        'id_akun' => 'string',          // varchar(255)
        'password' => 'hashed',         // varchar(255), hashed
        'nama_pendeta' => 'string',     // varchar(255)
        'no_telp' => 'string',          // varchar(255)
        'alamat' => 'string',           // text, nullable
        'region_id' => 'integer',       // bigint(20) unsigned
        'departemen_id' => 'integer',   // bigint(20) unsigned
        'gereja_id' => 'integer',       // bigint(20) unsigned, nullable
        'created_at' => 'datetime',     // timestamp, nullable
        'updated_at' => 'datetime',     // timestamp, nullable
    ];

    // Relasi
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }

    public function gereja()
    {
        return $this->belongsTo(Gereja::class, 'gereja_id');
    }

    public function permohonanPerpindahans()
    {
        return $this->hasMany(PermohonanPerpindahan::class);
    }

    public function perlawatans()
    {
        return $this->hasMany(Perlawatan::class);
    }

    public function penjadwalans()
    {
        return $this->hasMany(Penjadwalan::class);
    }

    public function regionHistories()
    {
        return $this->hasMany(RegionPendeta::class);
    }

    public function jabatanHistories()
    {
        return $this->hasMany(JabatanPendeta::class);
    }

    // Chat relationships
    public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(ChatMessage::class, 'receiver_id');
    }

    // Use the default primary key for authentication
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role ?? 'pendeta',
        ];
    }
}
