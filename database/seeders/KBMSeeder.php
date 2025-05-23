<?php

namespace Database\Seeders;

use App\Models\KBMModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KBMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KBMModel::create([
            'hari' => 1,
            'jam_mulai' => '07:00',
            'jam_selesai' => '08:30',
            'id_mapel' => 1,
            'id_kls_jurusan' => 1,
            'nip' => '0001',
            'id_ta' => 1,
        ]);
        KBMModel::create([
            'hari' => 1,
            'jam_mulai' => '08:30',
            'jam_selesai' => '10:00',
            'id_mapel' => 2,
            'id_kls_jurusan' => 1,
            'nip' => '0001',
            'id_ta' => 1,
        ]);
        KBMModel::create([
            'hari' => 1,
            'jam_mulai' => '10:00',
            'jam_selesai' => '11:30',
            'id_mapel' => 3,
            'id_kls_jurusan' => 1,
            'nip' => '0001',
            'id_ta' => 1,
        ]);
    }
}
