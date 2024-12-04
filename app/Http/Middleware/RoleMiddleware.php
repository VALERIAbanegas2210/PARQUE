<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verifica si el usuario está autenticado y tiene el rol requerido
        if (Auth::guard('usuarios')->check() && Auth::usuario()->hasRole($role)) {
            return $next($request);
        }

        // Redirige si no tiene el rol
        return redirect()->route('user.usuariotemplate')->with('error', 'No tienes acceso a esta sección.');
    }
}