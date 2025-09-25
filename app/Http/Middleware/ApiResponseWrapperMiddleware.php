<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseWrapperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only wrap API responses that are JSON and have content
        if ($request->is('api/*') && $response instanceof JsonResponse && $response->getStatusCode() !== 204) {
            $tenant = $request->attributes->get('tenant');
            $originalData = json_decode($response->getContent(), true);

            // Only wrap if we have data to wrap
            if ($originalData !== null) {
                // Add tenant info to the response
                $wrappedData = [
                    'tenant_id' => $tenant?->id,
                    'tenant_name' => $tenant?->name,
                    ...$originalData
                ];

                $response->setContent(json_encode($wrappedData));
            }
        }

        return $response;
    }
}
