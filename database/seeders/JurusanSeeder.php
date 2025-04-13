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
            'nama_jurusan' => 'Teknik Informatika',
        ]);
        JurusanModel::create([
            'nama_jurusan' => 'Sistem Informasi',
        ]);
        JurusanModel::create([
            'nama_jurusan' => 'Teknik Komputer',
        ]);
        JurusanModel::create([
            'nama_jurusan' => 'Teknik Jaringan',
        ]);
        JurusanModel::create([
            'nama_jurusan' => 'Teknik Multimedia',
        ]);
        JurusanModel::create([
            'nama_jurusan' => 'Teknik Elektronika',
        ]);
    }
}
