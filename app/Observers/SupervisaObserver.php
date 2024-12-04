<?php

namespace App\Observers;

use App\Models\Bitacora_Guardaparque;
use App\Models\comunidad;
use App\Models\Supervisa;
use App\Models\Guardaparque;

class SupervisaObserver
{
    /**
     * Handle the Supervisa "created" event.
     */
    public function created(Supervisa $supervisa): void
    {
        // Obtener los datos necesarios del guardaparque y la comunidad
        $guardaparque = Guardaparque::find($supervisa->guardaparque_id);
        $comunidad = comunidad::find($supervisa->comunidad_id);

        // Insertar en la bitácora con tipo 'I' (insert)
        Bitacora_Guardaparque::create([
            'tipo' => 'I',
            'fecha' => now(),
            'nombreGuardaparque' => $guardaparque->nombre ?? 'Desconocido',
            'nombreComunidad' => $comunidad->nombre ?? 'Desconocido',
            'id_guardaparque' => $supervisa->guardaparque_id,
            'id_comunidad' => $supervisa->comunidad_id,
        ]);
    }

    /**
     * Handle the Supervisa "updated" event.
     */
    public function updated(Supervisa $supervisa): void
    {
        //
    }

    /**
     * Handle the Supervisa "deleted" event.
     */
    public function deleted(Supervisa $supervisa): void
    {
        
        // Obtener los datos necesarios del guardaparque y la comunidad
        $guardaparque = Guardaparque::find($supervisa->guardaparque_id);
        $comunidad = Comunidad::find($supervisa->comunidad_id);

        // Insertar en la bitácora con tipo 'D' (delete)
        Bitacora_Guardaparque::create([
            'tipo' => 'D',
            'fecha' => now(),
            'nombreGuardaparque' => $guardaparque->nombre ?? 'Desconocido',
            'nombreComunidad' => $comunidad->nombre ?? 'Desconocido',
            'id_guardaparque' => $supervisa->guardaparque_id,
            'id_comunidad' => $supervisa->comunidad_id,
        ]);

    }

    /**
     * Handle the Supervisa "restored" event.
     */
    public function restored(Supervisa $supervisa): void
    {
        //
    }

    /**
     * Handle the Supervisa "force deleted" event.
     */
    public function forceDeleted(Supervisa $supervisa): void
    {
        //
    }
}
