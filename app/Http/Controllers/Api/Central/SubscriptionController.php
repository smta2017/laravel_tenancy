<?php

namespace App\Http\Controllers\API\Central;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laravelcm\Subscriptions\Models\Subscription;

class SubscriptionController extends AppBaseController
{
    public function index()
    {
        $subscriptions = Subscription::with(['plan', 'subscriber'])->get();
        return $this->sendResponse($subscriptions, 'Subscriptions retrieved successfully');
    }

    public function show($id)
    {
        $subscription = Subscription::with(['plan', 'subscriber'])->find($id);
        if (!$subscription) {
            return $this->sendError('Subscription not found');
        }
        return $this->sendResponse($subscription, 'Subscription retrieved successfully');
    }

    public function destroy($id)
    {
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return $this->sendError('Subscription not found');
        }
        $subscription->delete();
        return $this->sendResponse($id, 'Subscription deleted successfully');
    }
}
