<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RutaTuristicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ruta_turisticas')->insert([
            [
                'nombre' => 'Cañon Colorado',
                'comunidad_id' => 2,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Cañon Esmeralda',
                'comunidad_id' => 2,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Bosque de los helechos',
                'comunidad_id' => 3,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Volcanes',
                'comunidad_id' => 3,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:25:17',
                'updated_at' => '2024-12-01 16:25:17',
            ],
            [
                'nombre' => 'Lagunas',
                'comunidad_id' => 1,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:25:24',
                'updated_at' => '2024-12-01 16:25:24',
            ],
            
            [
                'nombre' => 'Sendero a las cavernas',
                'comunidad_id' => 2,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:32:51',
                'updated_at' => '2024-12-01 16:32:51',
            ],
            [
                'nombre' => 'Cascadas Escondidas',
                'comunidad_id' => 2,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:34:15',
                'updated_at' => '2024-12-01 16:34:15',
            ],
            [
                'nombre' => 'Miradores Naturales',
                'comunidad_id' => 2,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:34:29',
                'updated_at' => '2024-12-01 16:34:29',
            ],
            [
                'nombre' => 'Ruta de las aves',
                'comunidad_id' => 3,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:34:56',
                'updated_at' => '2024-12-01 16:34:56',
            ],
            [
                'nombre' => 'Cueva de los murcielagos',
                'comunidad_id' => 3,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:35:14',
                'updated_at' => '2024-12-01 16:35:14',
            ],
            [
                'nombre' => 'Reserva de los palmitos',
                'comunidad_id' => 3,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:35:27',
                'updated_at' => '2024-12-01 16:35:27',
            ],
            [
                'nombre' => 'Senderos de la selva',
                'comunidad_id' => 1,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:35:59',
                'updated_at' => '2024-12-01 16:35:59',
            ],
            [
                'nombre' => 'Cascadas de Mataracu',
                'comunidad_id' => 1,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:36:11',
                'updated_at' => '2024-12-01 16:36:11',
            ],
            [
                'nombre' => 'Mirador de los Gigantes verdes',
                'comunidad_id' => 1,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:36:29',
                'updated_at' => '2024-12-01 16:36:29',
            ],
            [
                'nombre' => 'Cataratas del Río Saguayo',
                'comunidad_id' => 5,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:36:47',
                'updated_at' => '2024-12-01 16:36:47',
            ],
            [
                'nombre' => 'Sendero de las Mariposas',
                'comunidad_id' => 5,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:36:47',
                'updated_at' => '2024-12-01 16:36:57',
            ],
            [
                'nombre' => 'Caminos del Río Surutú',
                'comunidad_id' => 7,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:37:24',
                'updated_at' => '2024-12-01 16:37:24',
            ],
            [
                'nombre' => 'Bosque Encantado',
                'comunidad_id' => 7,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:37:38',
                'updated_at' => '2024-12-01 16:37:38',
            ],
            [
                'nombre' => 'Ruta de los Ríos',
                'comunidad_id' => 4,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:37:58',
                'updated_at' => '2024-12-01 16:37:58',
            ],
            [
                'nombre' => 'Zona de los Guacamayos',
                'comunidad_id' => 4,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:38:13',
                'updated_at' => '2024-12-01 16:38:13',
            ],
            [
                'nombre' => 'Sendero de la Vida',
                'comunidad_id' => 6,
                'disponibilidad' => 'DISPONIBLE',
                'created_at' => '2024-12-01 16:38:49',
                'updated_at' => '2024-12-01 16:38:49',
            ],
        ]);
    }
}
