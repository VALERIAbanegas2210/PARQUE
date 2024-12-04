<?php

namespace Database\Seeders;

use App\Models\tipo_entrada;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEntradaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tipo_entrada::create([
            'nombre' => 'Estudiante',
            'precio' => '10',
            'descripcion' => 'Solo ingreso con CI (IMPORTANTE)',
        ]);
        tipo_entrada::create([
            'nombre' => 'Extranjero',
            'precio' => '100',
            'descripcion' => 'Solo ingreso con Pasaporte (IMPORTANTE)',
        ]);
        tipo_entrada::create([
            'nombre' => 'Nacional',
            'precio' => '20',
            'descripcion' => 'Solo ingreso con CI y mayoria de edad (IMPORTANTE)',
        ]);
        tipo_entrada::create([
            'nombre' => 'Extranjero-Menor',
            'precio' => '10',
            'descripcion' => 'Solo ingreso con Pasaporte (IMPORTANTE)',
        ]);
    }
}