<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanPendeta extends Model
{
    use HasFactory;

    protected $table = 'jabatan_pendetas';

    protected $fillable = [
        'pendeta_id',
        'jabatan_id',
        'gereja_id',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    protected $casts = [
        'tanggal_awal' => 'date',
        'tanggal_akhir' => 'date',
    ];

    public function pendeta()
    {
        return $this->belongsTo(Pendeta::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function gereja()
    {
        return $this->belongsTo(Gereja::class);
    }
}

