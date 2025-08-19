<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gereja extends Model
{
    use HasFactory;

    protected $table = 'gerejas';

    protected $fillable = [
        'nama_gereja',
        'alamat',
        'region_id',
    ];

    // Relasi
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function pendetas()
    {
        return $this->hasMany(Pendeta::class);
    }

    public function anggotas()
    {
        return $this->hasMany(Anggota::class);
    }
}