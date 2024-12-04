<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Guardaparque;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $userAdmin=usuario::create([
            'nombre' => 'Admin User', // Make sure to provide a name
            'usuario' => 'DIEGOADMIN1',
            'correo' => 'diegohonor43@gmail.com',
            'contraseña' => Hash::make('123456789'),
            'ci' => '123456789',
            'edad' => 18,
            'sexo' => 'MASCULINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
            'nroCelular'=>"121223"
        ])->syncRoles('admin'); // Esto asigna el rol admin al usuario, asegurándote que el guard sea 'usuarios'

        Guardaparque::create([
            'id'=>$userAdmin->id,
            'CI' => '123456789',
            'nombre' => 'Admin User', // Make sure to provide a name
            'edad' => 18,
            'sexo' => 'MASCULINO',
            'correo' => 'diegohonor43@gmail.com',
            'contraseña' => Hash::make('123456789'),
            'nroCelular'=>"121223"
        ]);
        
        usuario::create([
            'nombre' => 'John Doe Guarda', // Provide the required 'nombre' field
            'usuario' => 'DIEGO2GUARDIAN1',
            'correo' => 'chambidiego45@gmail.com',
            'contraseña' => Hash::make('123456789'),
            'ci' => '1234123123',
            'edad' => 22,
            'sexo' => 'MASCULINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
        ])->syncRoles('guardaparque');

        usuario::create([
            'nombre' => 'fernando', // Provide the required 'nombre' field
            'usuario' => 'muerte',
            'correo' => 'fernando201469@gmail.com',
            'contraseña' => Hash::make('123456789'),
            'ci' => '12345678',
            'edad' => 22,
            'sexo' => 'MASCULINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
        ])->syncRoles('usuario');
         
        /*Usuario::create([
            'nombre' => 'muerte', // Provide the required 'nombre' field
            'usuario' => 'muerte',
            'correo' => 'muerte201469@gmail.com',
            'contraseña' => Hash::make('12345678'),
            'ci' => '300',
            'edad' => 22,
            'sexo' => 'MASCULINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
            'nroCelular'=>'1233'
        ])->syncRoles('usuario');
        Usuario::create([
            'nombre' => 'parca', // Provide the required 'nombre' field
            'usuario' => 'parca',
            'correo' => 'parca201469@gmail.com',
            'contraseña' => Hash::make('12345678'),
            'ci' => '301',
            'edad' => 22,
            'sexo' => 'MASCULINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
            'nroCelular'=>'1234'
        ])->syncRoles('usuario');*/
        /*Usuario::create([
            'nombre' => 'parca', // Provide the required 'nombre' field
            'usuario' => 'parca',
            'correo' => 'parca201469@gmail.com',
            'contraseña' => Hash::make('12345678'),
            'ci' => '301',
            'edad' => 22,
            'sexo' => 'MASCULINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
            'nroCelular'=>'1234'
        ])->syncRoles('usuario');*/
        usuario::create([
            'nombre' => 'Juan',
            'usuario' => 'juanito',
            'correo' => 'juanito@gmail.com',
            'contraseña' => Hash::make('12345678'),
            'ci' => '302',
            'edad' => 25,
            'sexo' => 'MASCULINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
            'nroCelular' => '1235'
        ])->syncRoles('usuario');

        

        usuario::create([
            'nombre' => 'Luis',
            'usuario' => 'lucho',
            'correo' => 'luis@gmail.com',
            'contraseña' => Hash::make('12345678'),
            'ci' => '306',
            'edad' => 27,
            'sexo' => 'MASCULINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
            'nroCelular' => '1239'
        ])->syncRoles('usuario');





        // Crear usuario Valeria Banegas con rol 'usuario'
        usuario::create([
            'nombre' => 'Valeria Banegas',
            'usuario' => 'valeria',
            'correo' => 'valeria@gmail.com',
            'contraseña' => Hash::make('123456789'),
            'ci' => '401',
            'edad' => 25,
            'sexo' => 'FEMENINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
            'nroCelular' => '7654321'
        ])->syncRoles('usuario');

        // Crear usuario Andrés Quispe con rol 'guardaparque'
        $usuarioAndres=usuario::create([
            'nombre' => 'Andrés Quispe',
            'usuario' => 'andres',
            'correo' => 'andres@gmail.com',
            'contraseña' => Hash::make('123456789'),
            'ci' => '402',
            'edad' => 23,
            'sexo' => 'MASCULINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
            'nroCelular' => '7654322'
        ])->syncRoles('guardaparque');


        Guardaparque::create([
            'id'=>$usuarioAndres->id,
            'CI' => $usuarioAndres->ci,
            'nombre' => $usuarioAndres->nombre, // Make sure to provide a name
            'edad' => $usuarioAndres->edad,
            'sexo' => $usuarioAndres->sexo,
            'correo' => $usuarioAndres->correo,
            'contraseña' => $usuarioAndres->contraseña,
            'nroCelular'=>$usuarioAndres->nroCelular
        ]);

        // Crear usuario Diego Chambi con rol 'usuario'
        usuario::create([
            'nombre' => 'Diego Chambi',
            'usuario' => 'diego',
            'correo' => 'diego@gmail.com',
            'contraseña' => Hash::make('123456789'),
            'ci' => '403',
            'edad' => 23,
            'sexo' => 'FEMENINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
            'nroCelular' => '7654323'
        ])->syncRoles('usuario');

        // Crear usuario Oliver Ventura con rol 'guardaparque'
        $usuarioVentura=usuario::create([
            'nombre' => 'Oliver Ventura',
            'usuario' => 'oliver',
            'correo' => 'oliver@gmail.com',
            'contraseña' => Hash::make('123456789'),
            'ci' => '404',
            'edad' => 23,
            'sexo' => 'MASCULINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
            'nroCelular' => '7654324'
        ])->syncRoles('guardaparque');


        Guardaparque::create([
            'id'=>          $usuarioVentura->id,
            'CI' =>         $usuarioVentura->ci,
            'nombre' =>     $usuarioVentura->nombre, // Make sure to provide a name
            'edad' =>       $usuarioVentura->edad,
            'sexo' =>       $usuarioVentura->sexo,
            'correo' =>     $usuarioVentura->correo,
            'contraseña' => $usuarioVentura->contraseña,
            'nroCelular'=>  $usuarioVentura->nroCelular
        ]);
        // Crear usuario Víctor Ugarteche con rol 'usuario'
        $usuarioVictor=usuario::create([
            'nombre' => 'Víctor Ugarteche',
            'usuario' => 'victor',
            'correo' => 'victor@gmail.com',
            'contraseña' => Hash::make('123456789'),
            'ci' => '405',
            'edad' => 23,
            'sexo' => 'MASCULINO',
            'pasaporte' => '',
            'nacionalidad' => 'Bolivia',
            'profile_image' => '',
            'nroCelular' => '7654325'
        ])->syncRoles('guardaparque');

        Guardaparque::create([
            'id'=>          $usuarioVictor->id,
            'CI' =>         $usuarioVictor->ci,
            'nombre' =>     $usuarioVictor->nombre, // Make sure to provide a name
            'edad' =>       $usuarioVictor->edad,
            'sexo' =>       $usuarioVictor->sexo,
            'correo' =>     $usuarioVictor->correo,
            'contraseña' => $usuarioVictor->contraseña,
            'nroCelular'=>  $usuarioVictor->nroCelular
        ]);

    
    }
}