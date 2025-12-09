<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         //=============================================================
        //=============================================================
        //===============          with laravel valet      ============
        //===============    create v.host with v.domain   ============
        //===============         named saas.test          ============
        //=============================================================
        //=============================================================

        $tenants = ['1_foo', '2_bar', '3_baz', '4_basel', '5_quux', '6_corge', '7_patto', '8_garply', '9_boshy', '0_fred'];

        // for ($i = 0; $i < 10; $i++) {
        foreach ($tenants as $newtenant) {

            // $tenant = 'foo_' . time();

            $newtenant = $newtenant . time();

            if (!Tenant::find($newtenant)) {
                $tenant = Tenant::create(['id' => $newtenant]);
                $tenant->domains()->create(['domain' => $newtenant . '.saas.test']);

                tenancy()->initialize($tenant);
                // User::factory()->create([
                //     'name' => $newtenant . ' User',
                //     'email' => 'test_' . $newtenant . '@example.com',
                // ]);

                User::factory(3)->create();
            }
        }
    }
    
    // $plan = \Laravelcm\Subscriptions\Models\Plan::create([
    //     'name' => 'Pro',
    //     'description' => 'Pro plan',
    //     'price' => 9.99,
    //     'signup_fee' => 1.99,
    //     'invoice_period' => 1,
    //     'invoice_interval' => \Laravelcm\Subscriptions\Interval::MONTH->value,
    //     'trial_period' => 15,
    //     'trial_interval' => \Laravelcm\Subscriptions\Interval::DAY->value,
    //     'sort_order' => 1,
    //     'currency' => 'USD',
    // ]);
    
    // $plan->features()->saveMany([
    //     new \Laravelcm\Subscriptions\Models\Feature(['name' => 'listings', 'value' => 50, 'sort_order' => 1]),
    //     new \Laravelcm\Subscriptions\Models\Feature(['name' => 'pictures_per_listing', 'value' => 10, 'sort_order' => 5]),
    //     new \Laravelcm\Subscriptions\Models\Feature(['name' => 'listing_duration_days', 'value' => 30, 'sort_order' => 10, 'resettable_period' => 1, 'resettable_interval' => 'month']),
    //     new \Laravelcm\Subscriptions\Models\Feature(['name' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
    // ]);
}


