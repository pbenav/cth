<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsSecurityHeaders
{
    /**
     * Handle an incoming request.
     * Añade cabeceras de seguridad requeridas por el Esquema Nacional de Seguridad (ENS).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Si la respuesta es una instancia de Response o JsonResponse, añadimos cabeceras
        if (method_exists($response, 'header')) {
            $response->header('X-Frame-Options', 'SAMEORIGIN'); // Evita clickjacking
            $response->header('X-XSS-Protection', '1; mode=block'); // Mitiga XSS
            $response->header('X-Content-Type-Options', 'nosniff'); // Evita MIME sniffing
            $response->header('Referrer-Policy', 'strict-origin-when-cross-origin'); // Privacidad de referer
            $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload'); // HSTS (solo efectivo en HTTPS)
            
            // Content Security Policy (CSP) básica recomendada para ENS
            // Permite recursos locales, scripts inline de Alpine/Livewire y datos
            $response->header('Content-Security-Policy', "default-src 'self' 'unsafe-inline' 'unsafe-eval' data: https: wss:;");
        }

        return $response;
    }
}
