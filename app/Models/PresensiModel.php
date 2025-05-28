<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiModel extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $fillable = [
        'id_kbm',
        'pertemuan_ke',
        'tanggal',
        'ket'
    ];

    public function kbm()
    {
        return $this->belongsTo(KBMModel::class, 'id_kbm', 'id');
    }
}
 