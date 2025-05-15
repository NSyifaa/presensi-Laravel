<?php

namespace Database\Seeders;

use App\Models\GuruModel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GuruModel::create([
            "nip" => "0001",
            "nama" => "guru1",
            "no_hp" => "081234567890",
            "kelamin" => "L",
            "alamat" => "Jl. Raya No. 1, Jakarta",
        ]);

        GuruModel::create([
            "nip" => "0002",
            "nama" => "guru2",
            "no_hp" => "081234567333",
            "kelamin" => "P",
            "alamat" => "Jl. Raya No. 2, Jakarta",
        ]);

        User::create([
            'username' => '0001',
            'password' => bcrypt('0001'),
            'role' => 'guru',
            'name' => 'guru1',
        ]);
        User::create([
            'username' => '0002',
            'password' => bcrypt('0002'),
            'role' => 'guru',
            'name' => 'guru2',
        ]);
    }
}
