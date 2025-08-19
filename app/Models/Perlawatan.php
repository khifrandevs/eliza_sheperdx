<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perlawatan extends Model
{
    use HasFactory;

    protected $table = 'perlawatans';

    protected $fillable = [
        'pendeta_id',
        'anggota_id',
        'tanggal',
        'lokasi',
        'gambar_bukti',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi
    public function pendeta()
    {
        return $this->belongsTo(Pendeta::class);
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}