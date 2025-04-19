<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaModel extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $fillable = [
        "nis",
        "nama_siswa",
        "jenis_kelamin",
        "no_telp",
        "stat",
        "foto",
        "kode_jurusan",
    ];
}
