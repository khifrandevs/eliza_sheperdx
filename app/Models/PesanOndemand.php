<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanOndemand extends Model
{
    use HasFactory;

    protected $table = 'pesan_ondemands';

    protected $fillable = [
        'anggota_id',
        'pendeta_id',
        'isi_pesan',
        'status',
        'tanggal_pesan',
    ];

    protected $casts = [
        'tanggal_pesan' => 'datetime',
    ];

    // Relasi
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function pendeta()
    {
        return $this->belongsTo(Pendeta::class);
    }
}