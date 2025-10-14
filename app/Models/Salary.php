<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salaries';

    protected $fillable = [
        'karyawan_id',
        'bulan',
        'gaji_pokok',
        'gaji_tunjangan',
        'potongan',
        'total_gaji',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'karyawan_id');
    }
}
