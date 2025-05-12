<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Guru',
            'username' => 'guru',
            'password' => bcrypt('guru'),
            'role' => 'guru',
        ]);
        User::create([
            'name' => 'siswa',
            'username' => 'siswa',
            'password' => bcrypt('siswa'),
            'role' => 'siswa',
        ]);
    }
}
