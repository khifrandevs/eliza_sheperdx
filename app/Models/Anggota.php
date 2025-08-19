<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';

    protected $fillable = [
        'nama_anggota',
        'no_telp',
        'alamat',
        'gereja_id',
    ];

    // Relasi
    public function gereja()
    {
        return $this->belongsTo(Gereja::class);
    }

    public function perlawatans()
    {
        return $this->hasMany(Perlawatan::class);
    }

    public function pesanOndemands()
    {
        return $this->hasMany(PesanOndemand::class);
    }
}