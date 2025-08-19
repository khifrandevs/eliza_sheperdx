<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjadwalan extends Model
{
    use HasFactory;

    protected $table = 'penjadwalans';

    protected $fillable = [
        'pendeta_id',
        'judul_kegiatan',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'gambar_bukti',
        'lokasi',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    // Relasi
    public function pendeta()
    {
        return $this->belongsTo(Pendeta::class);
    }
}