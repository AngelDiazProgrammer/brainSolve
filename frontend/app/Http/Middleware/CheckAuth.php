<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Si el usuario no está autenticado, redirigir al login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Por favor inicia sesión.');
        }

        return $next($request);
    }
}
