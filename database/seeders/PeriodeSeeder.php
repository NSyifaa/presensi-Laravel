<?php

namespace Database\Seeders;

use App\Models\PeriodeModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PeriodeModel::create([
            'tahun' => '2024/2025',
            'semester' => '1',
            'status' => 'A',
        ]);
        PeriodeModel::create([
            'tahun' => '2024/2025',
            'semester' => '2',
            'status' => 'T',
        ]);
        PeriodeModel::create([
            'tahun' => '2025/2026',
            'semester' => '1',
            'status' => 'T',
        ]);
        PeriodeModel::create([
            'tahun' => '2025/2026',
            'semester' => '2',
            'status' => 'T',
        ]);
        PeriodeModel::create([
            'tahun' => '2026/2027',
            'semester' => '1',
            'status' => 'T',
        ]);
        PeriodeModel::create([
            'tahun' => '2026/2027',
            'semester' => '2',
            'status' => 'T',
        ]);
    }
}
