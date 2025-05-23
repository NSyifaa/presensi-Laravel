<?php

namespace Database\Seeders;

use App\Models\KelasSiswaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KelasSiswaModel::insert([
            [
                'id_kls_jurusan' => '1',
                'nis' => '111',
            ],
            [
                'id_kls_jurusan' => '1',
                'nis' => '123',
            ],
            
        ]);
    }
}
