<?php

namespace Database\Seeders;

use App\Models\CentralUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laravelcm\Subscriptions\Interval;
use Laravelcm\Subscriptions\Models\Feature;
use Laravelcm\Subscriptions\Models\Plan;

class TenantsSeeder extends Seeder
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


        $tenants = ['1_foo', '2_bar', '3_baz'];


        foreach ($tenants as $newtenant) {

            if (!Tenant::find($newtenant)) {
                $tenant = Tenant::create(['id' => $newtenant]);
                $tenant->domains()->create(['domain' => $newtenant . '.saas.test']);
            }
        }
    }
}
