<?php

namespace Database\Seeders;

use App\Models\SiswaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiswaModel::create([
            'nis' => '1234567890',
            'nama_siswa' => 'Matien',
            'jenis_kelamin' => 'L',
            'no_telp' => '081234567890',
            'stat' => 'A',
            'foto' => null,
            'kode_jurusan' => 'TKR',
        ]);
        SiswaModel::create([
            'nis' => '22312',
            'nama_siswa' => 'Naylu',
            'jenis_kelamin' => 'P',
            'no_telp' => '081234567899',
            'stat' => 'T',
            'foto' => null,
            'kode_jurusan' => 'MM',
        ]);
    }
}
