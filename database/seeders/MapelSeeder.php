<?php

namespace Database\Seeders;

use App\Models\MapelModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapel = [
            ['nama_mapel' => 'Matematika'],
            ['nama_mapel' => 'Bahasa Indonesia'],
            ['nama_mapel' => 'Bahasa Inggris'],
            ['nama_mapel' => 'Biologi'],
            ['nama_mapel' => 'Kimia'],
            ['nama_mapel' => 'Fisika'],
            ['nama_mapel' => 'Ekonomi'],
            ['nama_mapel' => 'Geografi'],
            ['nama_mapel' => 'Sejarah'],
        ];

        MapelModel::insert($mapel);
    }
}
