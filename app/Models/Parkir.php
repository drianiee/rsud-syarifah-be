<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parkir extends Model
{
    protected $fillable = [
        'tanggal','shift',
        'pendapatan_r2','pendapatan_r4',
        'jumlah_r2','jumlah_r4',
        'total','bulan','tahun',
    ];
}