<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class ApiLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Detectar idioma del usuario autenticado (si existe)
        if (auth()->check()) {
            $language = auth()->user()->language ?? 'es';
            App::setLocale($language);
        }
        // O usar header X-Language
        elseif ($request->hasHeader('X-Language')) {
            $language = $request->header('X-Language');
            if (in_array($language, ['en', 'es'])) {
                App::setLocale($language);
            }
        }
        // O usar idioma del tenant (si está disponible en la request)
        elseif ($request->attributes->has('tenant')) {
            $tenant = $request->attributes->get('tenant');
            if ($tenant && $tenant->creator) {
                $language = $tenant->creator->language ?? 'es';
                App::setLocale($language);
            }
        }

        return $next($request);
    }
}
