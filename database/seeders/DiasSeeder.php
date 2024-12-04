<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dias')->insert([
            ['nombre' => 'Lunes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Martes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Miércoles', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Jueves', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Viernes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Sábado', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Domingo', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
