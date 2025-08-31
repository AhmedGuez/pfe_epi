<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Client;

class ClientAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        // Skip middleware for admin users
        if (auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial')) {
            return $next($request);
        }

        // Get client ID from route parameters
        $clientId = $request->route('client') ?? $request->route('record');
        
        if ($clientId) {
            // Check if user has access to this client
            if (!auth()->user()->hasClientAccess($clientId, $role)) {
                abort(403, 'Vous n\'avez pas accès à ce client.');
            }
        }

        return $next($request);
    }
}
