<?php

namespace Database\Seeders;

use App\Models\JurusanModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JurusanModel::create([
            'kode_jurusan' => 'TKR',
            'nama_jurusan' => 'Teknik Kendaraan Ringan',
        ]);
        JurusanModel::create([
            'kode_jurusan' => 'TSM',
            'nama_jurusan' => 'Teknik Sepeda Motor',
        ]);
        JurusanModel::create([
            'kode_jurusan' => 'DKV',
            'nama_jurusan' => 'Desain Komunikasi Visual',
        ]);
        JurusanModel::create([
            'kode_jurusan' => 'TO',
            'nama_jurusan' => 'Teknik Otomotif',
        ]);
        JurusanModel::create([
            'kode_jurusan' => 'AKL',
            'nama_jurusan' => 'Akuntansi',
        ]);
    }
}
