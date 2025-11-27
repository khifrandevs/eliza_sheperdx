<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionPendeta extends Model
{
    use HasFactory;

    protected $table = 'region_pendetas';

    protected $fillable = [
        'pendeta_id',
        'region_id',
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

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}

