<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class ApiTokenAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Force JSON response for API routes
        $request->headers->set('Accept', 'application/json');

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        Auth::login($user);

        // Set locale based on Accept-Language header or user's locale
        $acceptLanguage = $request->header('Accept-Language');
        if ($acceptLanguage) {
            $language = explode(',', $acceptLanguage)[0] ?? 'en';
            $language = explode('-', $language)[0] ?? 'en';
        } else {
            $localeCode = $user->locale?->code ?? 'en';
            $language = explode('_', $localeCode)[0] ?? 'en';
        }
        App::setLocale($language);

        return $next($request);
    }
}
