<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerpindahanPendeta extends Model
{
    use HasFactory;

    protected $table = 'perpindahan_pendetas';

    protected $fillable = [
        'pendeta_id',
        'region_asal_id',
        'region_tujuan_id',
        'gereja_asal_id',
        'gereja_tujuan_id',
        'tanggal_perpindahan',
        'tanggal_aktif_melayani',
    ];

    protected $casts = [
        'tanggal_perpindahan' => 'date',
        'tanggal_aktif_melayani' => 'date',
    ];

    public function pendeta()
    {
        return $this->belongsTo(Pendeta::class);
    }

    public function regionAsal()
    {
        return $this->belongsTo(Region::class, 'region_asal_id');
    }

    public function regionTujuan()
    {
        return $this->belongsTo(Region::class, 'region_tujuan_id');
    }

    public function gerejaAsal()
    {
        return $this->belongsTo(Gereja::class, 'gereja_asal_id');
    }

    public function gerejaTujuan()
    {
        return $this->belongsTo(Gereja::class, 'gereja_tujuan_id');
    }
}

