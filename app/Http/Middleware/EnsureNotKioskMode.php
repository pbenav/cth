<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureNotKioskMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario está logueado en modo Kiosko (Numpad)
        if (session('kiosk_mode') === true) {
            
            // Rutas permitidas en modo Kiosko
            $allowedRoutes = [
                'inicio', 
                'logout', 
                'front', 
                'landing', 
                'set-locale',
                'kiosk.unlock'
            ];
            
            // Permitir peticiones internas de Livewire
            if ($request->is('livewire/*')) {
                return $next($request);
            }
            
            // Si la ruta actual está en la lista de permitidas, continuamos
            if ($request->route() && in_array($request->route()->getName(), $allowedRoutes)) {
                return $next($request);
            }

            // Si intentan acceder a cualquier otra zona, los bloqueamos y redirigimos a la pantalla de desbloqueo
            return redirect()->guest(route('kiosk.unlock'));
        }

        return $next($request);
    }
}
