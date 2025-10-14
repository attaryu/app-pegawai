<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok',
    ];
}
