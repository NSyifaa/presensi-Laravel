<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KBMModel extends Model
{
    use HasFactory;

    protected $table = 'kbm';
    protected $fillable = [
        "hari",
        'jam_mulai',
        'jam_selesai',
        'id_mapel',
        'id_kls_jurusan',
        'nip',
        'id_ta', 
    ];
    public function mapel()
    {
        return $this->belongsTo(MapelModel::class, 'id_mapel', 'id');
    }
    public function kelas()
    {
        return $this->belongsTo(KelasJurusanModel::class, 'id_kls_jurusan', 'id');
    }
    public function guru()
    {
        return $this->belongsTo(GuruModel::class, 'nip', 'nip');
    }
    public function tahunAjaran()
    {
        return $this->belongsTo(PeriodeModel::class, 'id_ta', 'id');
    }
    public function presensi()
    {
        return $this->hasMany(PresensiModel::class, 'id_kbm', 'id');
    }
}
