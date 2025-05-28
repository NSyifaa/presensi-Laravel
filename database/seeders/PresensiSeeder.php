<?php

namespace Database\Seeders;

use App\Models\PresensiModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PresensiModel::insert([
            [
                'id_kbm' => 1,
                'pertemuan_ke' => '01',
                'tanggal' => '2025-05-28',
                'ket' => 'A',
            ],
            [
                'id_kbm' => 1,
                'pertemuan_ke' => '02',
                'tanggal' => '2025-06-04',
                'ket' => 'T',
            ],
            [
                'id_kbm' => 2,
                'pertemuan_ke' => '01',
                'tanggal' => '2025-05-29',
                'ket' => 'A',
            ],
        ]);
    }
}
