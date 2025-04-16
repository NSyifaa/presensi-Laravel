<?php

namespace Database\Seeders;

use App\Models\KelasModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KelasModel::insert([
            [
                'kode_kelas' => 'X',
                'kelas' => 'X',
            ],
            [
                'kode_kelas' => 'XI',
                'kelas' => 'XI',
            ],
            [
                'kode_kelas' => 'XII',
                'kelas' => 'XII',
            ],
        ]);
    }
}
