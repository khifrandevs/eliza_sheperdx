<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanPerpindahan extends Model
{
    use HasFactory;

    protected $table = 'permohonan_perpindahans';

    protected $fillable = [
        'pendeta_id',
        'region_asal_id',
        'region_tujuan_id',
        'alasan',
        'status',
        'tanggal_permohonan',
    ];

    protected $casts = [
        'tanggal_permohonan' => 'date',
        'status' => 'string', // Opsional, untuk memastikan enum ditangani sebagai string
        'created_at' => 'datetime', // Opsional, untuk kejelasan
        'updated_at' => 'datetime', // Opsional, untuk kejelasan
    ];

    // Relasi
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
}