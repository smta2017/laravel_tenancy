<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ImpersonateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Temporarily switch to the stateful guard (sanctum_stateful) to impersonate the user
        Auth::shouldUse('sanctum_stateful');

        $response = $next($request);

        // Revert back to the stateless Sanctum guard
        Auth::shouldUse('sanctum');

        return $response;
    }
}
