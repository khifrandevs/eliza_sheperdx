<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Departemen extends Authenticatable
{
    use HasFactory;

    protected $table = 'departemens';
    protected $guarded = [];
    protected $primaryKey = 'id';
}