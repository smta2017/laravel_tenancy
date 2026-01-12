<?php

namespace Database\Seeders;

use App\Models\CentralUser;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravelcm\Subscriptions\Interval;
use Laravelcm\Subscriptions\Models\Feature;
use Laravelcm\Subscriptions\Models\Plan;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CentralUser::factory()->create(
            [
                'name' => 'Supper Admin',
                'email' => 'supperadmin@saas.test',
                'account_verified_at' => Carbon::now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => \Str::random(10),
                'is_active' => true,
                'phone' => '+201234567890'
            ]
        );

        $freePlan = Plan::create([
            'name'             => 'Free',
            'description'      => 'Free plan',
            'price' => 0.0,
            'signup_fee' => 0.0,
            'invoice_period' => 10,
            'invoice_interval' => Interval::YEAR->value,
            'trial_period' => 0,
            'trial_interval' => Interval::DAY->value,
            'sort_order'       => 1,
            'currency'         => 'EGP',
        ]);
        $planSilver = Plan::create([
            'name' => 'Silver',
            'description' => 'Silver plan',
            'price' => 1489.0,
            'signup_fee' => 0.0,
            'invoice_period' => 1,
            'invoice_interval' => Interval::MONTH->value,
            'trial_period' => 15,
            'trial_interval' => Interval::DAY->value,
            'sort_order' => 2,
            'currency' => 'EGP',
        ]);
        $planGold = Plan::create([
            'name' => 'Gold',
            'description' => 'Gold plan',
             'price' => 2989.0,
            'signup_fee' => 0.0,
            'invoice_period' => 1,
            'invoice_interval' => Interval::MONTH->value,
            'trial_period' => 15,
            'trial_interval' => Interval::DAY->value,
            'sort_order' => 3,
            'currency' => 'EGP',
        ]);
        // $planPlatinum = Plan::create([
        //     'name' => 'Platinum',
        //     'description' => 'platinum plan',
        //     'price' => 2989.0,
        //     'signup_fee' => 0.0,
        //     'invoice_period' => 1,
        //     'invoice_interval' => Interval::MONTH->value,
        //     'trial_period' => 15,
        //     'trial_interval' => Interval::DAY->value,
        //     'sort_order' => 3,
        //     'currency' => 'EGP',
        // ]);

        $freePlan->features()->saveMany([
            new Feature(['name' => 'case.add', 'value' => 20, 'sort_order' => 1]),
            new Feature(['name' => 'liberary.searchs', 'value' => 10, 'sort_order' => 2]),
            new Feature(['name' => 'user.count', 'value' => 1, 'sort_order' => 3]),
            // newFeature(['name' => 'user.add', 'value' => 30, 'sort_order' => 10, 'resettable_period' => 1, 'resettable_interval' => 'month']),
            // newFeature(['name' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
        ]);

        $planSilver->features()->saveMany([
            new Feature(['name' => 'case.add', 'value' => 200, 'sort_order' => 1]),
            new Feature(['name' => 'liberary.searchs', 'value' => 1000, 'sort_order' => 2]),
            new Feature(['name' => 'user.count', 'value' => 5, 'sort_order' => 3]),
            // newFeature(['name' => 'user.add', 'value' => 30, 'sort_order' => 10, 'resettable_period' => 1, 'resettable_interval' => 'month']),
            // newFeature(['name' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
        ]);

        $planGold->features()->saveMany([
            new Feature(['name' => 'case.add', 'value' => 'Y', 'sort_order' => 1]),
            new Feature(['name' => 'liberary.searchs', 'value' => 'Y', 'sort_order' => 2]),
            new Feature(['name' => 'user.count', 'value' => 'Y', 'sort_order' => 3]),
            // newFeature(['name' => 'user.add', 'value' => 30, 'sort_order' => 10, 'resettable_period' => 1, 'resettable_interval' => 'month']),
            // newFeature(['name' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
        ]);
    }
}
