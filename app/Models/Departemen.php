<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Departemen extends Authenticatable
{
    use HasFactory;

    protected $table = 'departemens';
    protected $guarded = [];
    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'integer',              // bigint(20) unsigned, primary key
        'id_akun' => 'string',          // varchar(255)
        'password' => 'hashed',         // varchar(255), hashed
        'nama_departemen' => 'string',  // varchar(255)
        'deskripsi' => 'string',        // text, nullable
        'region_id' => 'integer',       // bigint(20) unsigned
        'created_at' => 'datetime',     // timestamp, nullable
        'updated_at' => 'datetime',     // timestamp, nullable
    ];

    // Relasi
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function pendetas()
    {
        return $this->hasMany(Pendeta::class, 'departemen_id');
    }
}