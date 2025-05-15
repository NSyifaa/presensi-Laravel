<?php

namespace Database\Seeders;

use App\Models\SiswaModel;
use App\Models\User;
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
            "nis" => "111",
            "nama" => "Tien",
            "no_hp" => "081234567890",
            "kelamin" => "L",
            "alamat" => "Jl. Raya No. 1, Jakarta",
            "kode_jurusan" => "TKR",
        ]);

        SiswaModel::create([
            "nis" => "123",
            "nama" => "Nay",
            "no_hp" => "081234567333",
            "kelamin" => "P",
            "alamat" => "Jl. Raya No. 2, Jakarta",
            "kode_jurusan" => "TSM",
        ]);

        User::create([
            'username' => '111',
            'password' => bcrypt('111'),
            'role' => 'siswa',
            'name' => 'Tien',
        ]);
        User::create([
            'username' => '123',
            'password' => bcrypt('123'),
            'role' => 'siswa',
            'name' => 'Nay',
        ]);
      
    }
}
