<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ResponseTrait;

class CheckSubscription
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $subscriptionName = 'main',string $featureName = 'main'): Response
    {
        $user = auth()->user();

        if (!$user) {
            return $this->sendError("Unauthorized", 401);
        }

        $centralUser = $user->centralUser();

       $tenant = $centralUser->Tenants->first();
       if (!$tenant) {
            return $this->sendError("Tenant not found.", 403);
        }

        $subscription = $tenant->subscriptions->first();

        if (!$centralUser) {
            return $this->sendError("Central user profile not found.", 403);
        }

        $subscription = $centralUser->planSubscription($subscriptionName)->canUseFeature($featureName);

        if (!$subscription) {
            return $this->sendError("No active subscription found.", 403);
        }

        if (!$subscription->active()) {
            return $this->sendError("Your subscription is expired, please renew it.", 403);
        }

        return $next($request);
    }
}
