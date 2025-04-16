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
            'nama_jurusan' => 'Teknik Kendaraan Motor Ringan',
        ]);
        JurusanModel::create([
            'nama_jurusan' => 'Teknik dan Bisnis Sepeda Motor',
        ]);
        JurusanModel::create([
            'nama_jurusan' => 'Multimedia',
        ]);
        JurusanModel::create([
            'nama_jurusan' => 'Bisnis Daring dan Pemasaran',
        ]);
        JurusanModel::create([
            'nama_jurusan' => 'Akuntansi dan Keuangan Lembaga',
        ]);
    }
}
