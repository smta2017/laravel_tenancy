<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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

        $tenants = ['foo','bar','sab'];

        foreach ($tenants as $value) {
            if(!Tenant::find($value)){
                $tenant = Tenant::create(['id' => $value]);
                $tenant->domains()->create(['domain' => $value .'.saas.test']);
            }
        }

        // Tenant::all()->runForEach(function ($tn) {
        //     User::factory(10)->create();
        // });

        \App\Models\CentralUser::factory(3)->create();
        
    }
}