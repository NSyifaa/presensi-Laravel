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
            'nama_jurusan' => 'Teknik Kendaraan Motor Ringan',
        ]);
        JurusanModel::create([
            'kode_jurusan' => 'TSM',
            'nama_jurusan' => 'Teknik dan Bisnis Sepeda Motor',
        ]);
        JurusanModel::create([
            'kode_jurusan' => 'MM',
            'nama_jurusan' => 'Multimedia',
        ]);
        JurusanModel::create([
            'kode_jurusan' => 'BDP',
            'nama_jurusan' => 'Bisnis Daring dan Pemasaran',
        ]);
        JurusanModel::create([
            'kode_jurusan' => 'AKL',
            'nama_jurusan' => 'Akuntansi dan Keuangan Lembaga',
        ]);
    }
}
