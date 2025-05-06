<?php

namespace Database\Seeders;

use App\Models\KelasJurusanModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasJurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KelasJurusanModel::create([
            'nama_kelas' => '10 AKL 1',
            'kode_jurusan' => 'AKL',
            'kode_kelas' => 'X',
            'id_periode' => 1,
        ]);
        KelasJurusanModel::create([
            'nama_kelas' => '11 DKV 1',
            'kode_jurusan' => 'DKV',
            'kode_kelas' => 'XI',
            'id_periode' => 1,
        ]);
        KelasJurusanModel::create([
            'nama_kelas' => '12 TKR 1',
            'kode_jurusan' => 'TKR',
            'kode_kelas' => 'XII',
            'id_periode' => 1,
        ]);
    }
}
