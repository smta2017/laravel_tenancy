<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // For API-driven applications (SaaS Backend), never try to redirect
        // Let the Handler return the 401 JSON response instead of a RouteNotFoundException
        return null;
    }
}
