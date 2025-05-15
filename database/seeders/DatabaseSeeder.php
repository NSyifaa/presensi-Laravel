<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            PeriodeSeeder::class,
            JurusanSeeder::class,
            KelasSeeder::class,
            MapelSeeder::class,
            KelasJurusanSeeder::class,
            SiswaSeeder::class,
        ]);
    }
}
