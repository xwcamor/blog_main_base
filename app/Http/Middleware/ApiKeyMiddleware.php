<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = null;

        // Check for API key in Authorization header (Bearer token)
        $authorization = $request->header('Authorization');
        if ($authorization && str_starts_with($authorization, 'Bearer ')) {
            $apiKey = str_replace('Bearer ', '', $authorization);
        }

        // Fallback to X-API-Key header
        if (!$apiKey) {
            $apiKey = $request->header('X-API-Key');
        }

        if (!$apiKey) {
            return response()->json([
                'message' => 'API key is required'
            ], 401);
        }

        $tenant = Tenant::where('api_key', $apiKey)->first();

        if (!$tenant) {
            return response()->json([
                'message' => 'Invalid API key'
            ], 401);
        }

        // Attach tenant to request for later use
        $request->attributes->set('tenant', $tenant);

        return $next($request);
    }
}
