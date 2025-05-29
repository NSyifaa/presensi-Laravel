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

    public function presensi()
    {
        return $this->belongsTo(PresensiModel::class, 'id_presensi', 'id');
    }
    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'nis', 'nis');
    }
}
