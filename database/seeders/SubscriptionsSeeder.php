<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravelcm\Subscriptions\Models\Plan;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

class SubscriptionsSeeder extends Seeder
{
    use CentralConnection;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $gg = \DB::setDefaultConnection('mysql');
        $plan = Plan::first();
        $tenants = Tenant::all();
        foreach ($tenants as $tenant) {
            $subName = $tenant->id . "_" . $plan->name;
            $tenant->newPlanSubscription('main', $plan);
        }
    }
}
