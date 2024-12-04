<?php

namespace App\Listeners;

use App\Models\Bitacora;
use Illuminate\Auth\Events\Logout;

class LogLogout
{
    public function handle(Logout $event)
    {
        Bitacora::create([
            'user_id' => $event->user->id, // Acceso al ID del usuario
            'action' => 'CIERRE DE SESION',
            'ip_address' => request()->ip(),
        ]);
    }
}