<?php

namespace App\Observers;

use App\Models\Guardaparque;
use App\Models\usuario;
use Illuminate\Support\Facades\Hash;

class GuardaparqueObserver
{
    /**
     * Handle the Guardaparque "created" event.
     * trigger que se dispara cuando se crea un guardaparque
     */
    public function created(Guardaparque $guardaparque): void
    {
            // Deshabilitar temporalmente el observer de Usuario
            /*Usuario::withoutEvents(function () use ($guardaparque) {
                // Crear un usuario correspondiente
                $usuario = Usuario::create([
                    'nombre' => $guardaparque->nombre,
                    'usuario' => $guardaparque->nombre,
                    'correo' => $guardaparque->correo,
                    'contraseña' => $guardaparque->contraseña,
                    'ci' => $guardaparque->CI,
                    'edad' => $guardaparque->edad,
                    'sexo' => $guardaparque->sexo,
                    'pasaporte' => null,
                    'nacionalidad' => 'Bolivia',
                    'profile_image' => null,
                ]);

                // Asignar el rol 'guardaparque'
                $usuario->assignRole('guardaparque');
            });*/

    }

    /**
     * Handle the Guardaparque "updated" event.
     * * trigger que se dispara cuando se actualiza un objeto guardaparque
     * debe actualizar al usuario
     */
   /* public function updated(Guardaparque $guardaparque): void
    {
        //primero busco por correo,dado que el id del guardaparque no sera el mismo,o podria ser por carnet
        //ni modo lo hice por ci
        $usuarioGuardaparque=Usuario::where('ci',$guardaparque->CI)->first();
        if($usuarioGuardaparque){
            //actualizo los datos
            $usuarioGuardaparque->update([
                'nombre' => $guardaparque->nombre,
                'usuario' => $guardaparque->nombre,
                'ci' => $guardaparque->CI,
                'edad' => $guardaparque->edad,
                'sexo' => $guardaparque->sexo,
            ]);

            if ($guardaparque->isDirty('contraseña')) {
                $usuarioGuardaparque->update([
                    'password' => ($guardaparque->contraseña),//no la encriptamos por que si no tendriamos doble encriptacion,puesto a que ya encriptamos en el update
                ]);
            }

            //ahora verificamos que rol tiene
        }
        
    }*/

    /**
     * Handle the Guardaparque "deleted" event.
     * trigger que se dispara cuando se eliminar un objeto guardaparque
     */
    /*public function deleted(Guardaparque $guardaparque): void
    {
        //primero busco por correo,dado que el id del guardaparque no sera el mismo,o podria ser por carnet
        //ni modo lo hice por ci
        $usuarioGuardaparque=Usuario::where('ci',$guardaparque->CI)->first();
        if($usuarioGuardaparque){
            $usuarioGuardaparque->delete();
        }
    }*/ 

    /**
     * Handle the Guardaparque "restored" event.
     */
    public function restored(Guardaparque $guardaparque): void
    {
        //
    }

    /**
     * Handle the Guardaparque "force deleted" event.
     */
    public function forceDeleted(Guardaparque $guardaparque): void
    {
        //
    }
}
