<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'status',
        'departemen_id',
        'jabatan_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'departemen_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'jabatan_id');
    }
}
