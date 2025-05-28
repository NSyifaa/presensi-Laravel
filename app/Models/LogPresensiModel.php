<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPresensiModel extends Model
{
    protected $table = 'log_presensi';
    protected $fillable = [
        'id_presensi',
        'nis',
        'status',
    ];
}
