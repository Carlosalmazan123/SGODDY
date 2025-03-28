<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfClient
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
        if (Auth::check() && Auth::user()->hasRole('cliente')) {
            // Redirigir a la vista 'welcome' si el usuario tiene el rol 'cliente'
            return redirect()->route('welcome');
        }

        // Continuar con la solicitud si no tiene el rol 'cliente'
        return $next($request);
    }
}
