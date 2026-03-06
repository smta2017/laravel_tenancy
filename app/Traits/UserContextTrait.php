<?php

namespace App\Traits;

use App\Http\Resources\SubscriptionResource;
use Illuminate\Support\Facades\DB;
use Laravelcm\Subscriptions\Models\Subscription;

trait UserContextTrait
{
    /**
     * Unify the user response with SaaS context (tenant, subscription, etc.)
     *
     * @param mixed $user
     * @param string $message
     * @param string|null $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendUserResponse($user, $message, $token = null)
    {
        // Load roles with their permissions and direct permissions
        // $user->load(['roles.permissions', 'permissions']);
        $user->permissions = $user->roles->pluck('permissions')->flatten()->merge($user->permissions)->unique('id')->values();

        $tenant = tenant();
        $subdomain = $tenant->id;

        // Ensure we fetch the subscription from the central database
        DB::setDefaultConnection('mysql');
        $subscription = tenancy()->central(function () use ($tenant) {
            return Subscription::ofSubscriber($tenant)->with(['plan', 'plan.features', 'usage'])->first();
        });

        $data = [
            "user" => $user,
            "tenant_id" => $subdomain,
            "subscription" => new SubscriptionResource($subscription),
            "domain" => "$subdomain.saas.test",
            "redirectUrl" => "http://$subdomain.saas.test"
        ];

        if ($token) {
            $data["token"] = $token;
        }

        return $this->sendResponse($data, $message);
    }
}
