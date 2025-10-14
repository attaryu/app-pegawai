<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = "attendance";

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'karyawan_id');
    }
}
