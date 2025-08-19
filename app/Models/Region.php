<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'regions';

    protected $fillable = [
        'nama_region',
        'kode_region',
        'deskripsi',
    ];

    // Relasi
    public function pendetas()
    {
        return $this->hasMany(Pendeta::class);
    }

    public function departemens()
    {
        return $this->hasMany(Departemen::class);
    }

    public function gerejas()
    {
        return $this->hasMany(Gereja::class);
    }

    public function permohonanPerpindahanAsal()
    {
        return $this->hasMany(PermohonanPerpindahan::class, 'region_asal_id');
    }

    public function permohonanPerpindahanTujuan()
    {
        return $this->hasMany(PermohonanPerpindahan::class, 'region_tujuan_id');
    }
}