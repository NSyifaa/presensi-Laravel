<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasJurusanModel extends Model
{
    use HasFactory;

    protected $table = 'ta_kelas_jurusan';
    protected $fillable = [
        "nama_kelas",
        "kode_jurusan",
        "kode_kelas",
        "id_periode",
    ];

    public function jurusan()
    {
        return $this->belongsTo(JurusanModel::class, 'kode_jurusan', 'kode_jurusan');
    }
    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'id_periode', 'id');
    }
    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'kode_kelas', 'kode_kelas');
    }
}
