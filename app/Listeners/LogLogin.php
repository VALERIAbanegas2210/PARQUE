<?php

namespace App\Listeners;

use App\Models\Bitacora;
use Illuminate\Auth\Events\Login;

class LogLogin
{
    public function handle(Login $event)
    {
        Bitacora::create([
            'user_id' => $event->user->id, // Acceso al ID del usuario
            'action' => 'Inicio de sesión',
            'ip_address' => request()->ip(),
        ]);
    }
}