<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Si el usuario está autenticado, redirigir a la página principal
        if (Auth::check()) {
            return redirect()->route('user.layouts.template'); // Cambia la ruta según tu necesidad
        }

        return $next($request);
    }
}
