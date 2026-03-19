<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laravelcm\Subscriptions\Models\Plan;
use Laravelcm\Subscriptions\Models\Subscription;
use Illuminate\Support\Facades\DB;

class TenantSubscriptionController extends AppBaseController
{
    /**
     * Get available plans higher than the current one.
     */
    public function availablePlans()
    {
        $tenant = tenant();
        $currentSubscription = null;
        $plans = tenancy()->central(function () use ($tenant, &$currentSubscription) {
            $currentSubscription = Subscription::on('mysql')->where('subscriber_id', $tenant->id)
                ->where('subscriber_type', get_class($tenant))
                ->latest()
                ->first();
            
            $currentSortOrder = ($currentSubscription && $currentSubscription->plan) ? $currentSubscription->plan->sort_order : 0;

            return Plan::on('mysql')->with('features')
                ->where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->get()
                ->map(function ($plan) use ($currentSubscription) {
                    $plan->is_current = ($currentSubscription && $currentSubscription->plan_id == $plan->id);
                    $currentSortOrder = ($currentSubscription && $currentSubscription->plan) ? $currentSubscription->plan->sort_order : 0;
                    $plan->is_upgrade = $plan->sort_order > $currentSortOrder;

                    // 1- if plan.invoice_interval = month return "mo"
                    if ($plan->invoice_interval === 'month') {
                        $plan->invoice_interval = 'mo';
                    }

                    // 2- if plan feature value = Y return "Unlimited"
                    $plan->features->map(function ($feature) {
                        if ($feature->value === 'Y' || $feature->value === '-1') {
                            $feature->value = 'Unlimited';
                        }
                        return $feature;
                    });

                    return $plan;
                });
        });

        return $this->sendResponse($plans, 'Available plans retrieved successfully');
    }

    /**
     * Upgrade current tenant plan.
     */
    public function upgradePlan(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:mysql.plans,id'
        ]);

        $tenant = tenant();
        $newPlanId = $request->plan_id;

        try {
            tenancy()->central(function () use ($tenant, $newPlanId) {
                $subscription = Subscription::on('mysql')
                    ->where('subscriber_id', $tenant->id)
                    ->where('subscriber_type', get_class($tenant))
                    ->latest()
                    ->first();
                    
                $newPlan = Plan::on('mysql')->findOrFail($newPlanId);

                if ($subscription) {
                    $subscription->changePlan($newPlan);
                } else {
                    $tenant->newSubscription('main', $newPlan);
                }
            });

            return $this->sendSuccess('Plan upgraded successfully. Your new features are now active.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to upgrade plan: ' . $e->getMessage(), 500);
        }
    }
}
