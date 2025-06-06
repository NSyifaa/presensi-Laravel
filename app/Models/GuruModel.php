<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruModel extends Model
{
     use HasFactory;

    protected $table = 'guru';
    protected $fillable = [
        "nip",
        "nama",
        "no_hp",
        "kelamin",
        "alamat",
        'provinsi_id',
        'provinsi',
        'kabupaten_id',
        'kabupaten',
        'kecamatan_id',
        'kecamatan',
        'desa_id',
        'desa',
    ];
}
