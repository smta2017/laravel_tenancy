<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ResponseTrait;

    public function checkPermission($permission)
    {
        $user = auth()->user();

        if (!$user->can($permission)) {
            abort(403, 'Unauthorized');
        }
    }

    public function checkSubscription($subscription_name = 'main')
    {
        $c_user = auth()->user()->centralUser();
        $subscription = $c_user->planSubscription($subscription_name);

        if (!$subscription) {
            abort(403,'No active subscription found.');
        }

        if (!$subscription->active()) {
            abort(403, 'Your subscription is expired, please renew it.');
        }
    }
}
