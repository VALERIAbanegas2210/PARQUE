<?php

namespace App\Observers;

use App\Models\Guardaparque;
use App\Models\usuario;

class UsuarioObserver
{
    /**
     * Handle the Usuario "created" event.
     */
    public function created(usuario $usuario)
    {
        // Asigna el rol 'usuario' al nuevo usuario
        
            $usuario->assignRole('usuario');
        
    }

    /**
     * Handle the Usuario "updated" event.
     * se dispara antes de que actualize
     * este trigger lo que hace es actualizar a la tabla guardaparque,si parece al revez pero nimodo
     */
    public function updated(Usuario $usuario): void
    {
        // Verificar si el usuario tiene el rol 'guardaparque'
        if ($usuario->hasRole('guardaparque')) {
            // Buscar el registro en guardaparques usando el valor original del CI
            $guardaparque = Guardaparque::where('CI', $usuario->getOriginal('ci'))->first();

            // Si no existe el guardaparque, crearlo
            if (!$guardaparque) {
                Guardaparque::create([
                    'CI' => $usuario->ci,
                    'nombre' => $usuario->nombre,
                    'edad' => $usuario->edad,
                    'sexo' => $usuario->sexo,
                    'correo' => $usuario->correo,
                    'nroCelular' => $usuario->nroCelular, // Asegúrate de ajustar esto según el campo en `Usuario`
                    'contraseña' => $usuario->contraseña,
                ]);
                //$usuario->syncRoles(['guardaparque']);
            } else {
                // Si existe, actualizar sus datos
                $guardaparque->update([
                    'CI' => $usuario->ci,
                    'nombre' => $usuario->nombre,
                    'edad' => $usuario->edad,
                    'sexo' => $usuario->sexo,
                    'correo' => $usuario->correo,
                    'nroCelular' => $usuario->nroCelular,
                    'contraseña' => $usuario->contraseña,
                ]);
            }
        } else {
            // Si el usuario no tiene el rol 'guardaparque', eliminar el registro en guardaparques si existe
            $guardaparque = Guardaparque::where('CI', $usuario->getOriginal('ci'))->first();
            if ($guardaparque) {
                $guardaparque->delete();
            }
        }
    }

    /**
     * Handle the Usuario "deleted" event.
     */
    public function deleted(Usuario $usuario): void
    {
        //
    }

    /**
     * Handle the Usuario "restored" event.
     */
    public function restored(Usuario $usuario): void
    {
        //
    }

    /**
     * Handle the Usuario "force deleted" event.
     */
    public function forceDeleted(Usuario $usuario): void
    {
        //
    }
}