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
    public function handle(Request $request, Closure $next, string $subscriptionName, string $featureName): Response
    {
        $user = auth()->user();

        if (!$user) {
            return $this->sendError("Unauthorized", 401);
        }

        $tenant = tenant();

        if (!$tenant) {
            return $this->sendError("Tenant not found.", 403);
        }

        // Keep a reference to the active connection
        $previousConnection = \Illuminate\Support\Facades\DB::getDefaultConnection();
        \Illuminate\Support\Facades\DB::setDefaultConnection('mysql');

        $result = tenancy()->central(function () use ($tenant, $subscriptionName, $featureName) {
            $subscription = $tenant->planSubscription($subscriptionName);

            if (!$subscription) {
                return ["error" => "No active subscription found."];
            }

            if (!$subscription->active()) {
                return ["error" => "Your subscription is expired, please renew it."];
            }

            $usage = $subscription->usage()->byFeatureSlug($featureName, $subscription->plan_id)->first();

            if ($usage != null) {
                if (!$subscription->canUseFeature($featureName)) {
                    return ["error" => "Your plan limit for this feature has been reached."];
                }
            }

            return true;
        });

        // Restore the previous DB connection
        \Illuminate\Support\Facades\DB::setDefaultConnection($previousConnection);

        if (is_array($result)) {
            return $this->sendError($result['error'], 403);
        }

        return $next($request);
    }
}
