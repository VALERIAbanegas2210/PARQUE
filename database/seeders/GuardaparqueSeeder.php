<?php

namespace Database\Seeders;

use App\Models\Guardaparque;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuardaparqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //los admin tambien seran guardaparques,solo para tener un mejor esquema
        /*Guardaparque::create([
            'id'=>21,
            'CI' => '123456789',
            'nombre' => 'Admin User', // Make sure to provide a name
            'edad' => 18,
            'sexo' => 'MASCULINO',
            'correo' => 'diegohonor43@gmail.com',
            'contraseña' => Hash::make('123456789'),
            'nroCelular'=>"121223"
        ]);*/
        
    }
}
