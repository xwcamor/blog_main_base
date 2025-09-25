<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Update user language if authenticated and locale changed
        if (Auth::check()) {
            $currentLocale = app()->getLocale();
            $user = Auth::user();

            if ($user->language !== $currentLocale) {
                $user->update(['language' => $currentLocale]);
            }
        }

        return $response;
    }
}
