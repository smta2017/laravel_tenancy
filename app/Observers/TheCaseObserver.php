<?php

namespace App\Observers;

use App\Models\TheCase;

class TheCaseObserver
{
    public function creating(TheCase $theCase) {
        // check subscription if allowed to add cases based on tenant limitation, use CheckSubscription middleware
    }

    /**
     * Handle the TheCase "created" event.
     */
    public function created(TheCase $theCase): void
    {
        app(\App\Repositories\TheCaseRepository::class)->recordFeatureUsage('total-cases');
        \App\Services\NotificationService::caseAddNotify($theCase);
    }

    /**
     * Handle the TheCase "updated" event.
     */
    public function updated(TheCase $theCase): void
    {
        \App\Services\NotificationService::caseUpdateNotify($theCase);
    }

    /**
     * Handle the TheCase "deleted" event.
     */
    public function deleted(TheCase $theCase): void
    {
        //
    }

    /**
     * Handle the TheCase "restored" event.
     */
    public function restored(TheCase $theCase): void
    {
        //
    }

    /**
     * Handle the TheCase "force deleted" event.
     */
    public function forceDeleted(TheCase $theCase): void
    {
        //
    }
}
