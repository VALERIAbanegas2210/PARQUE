<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\RutaTuristica;
use App\Models\User;
use App\Models\Usuario;
use Database\Factories\UsuarioFactory; // Import the factory if necessary
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primero llama al RoleSeeder
        $this->call(RoleSeeder::class);


        // También puedes llamar a otros seeders aquí
        $this->call([
            AdministradorSeeder::class,
            UsuarioSeeder::class,
            TipoEntradaSeeder::class,
            ComunidadSeeder::class,
            DepartamentoSeeder::class,
            DiasSeeder::class,
            RutaTuristicaSeeder::class,
        ]);
    }
}