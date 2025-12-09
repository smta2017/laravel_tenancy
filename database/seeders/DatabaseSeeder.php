<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
      

        $this->call([
            MainSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            // TesureSeeder::class,
            // CentralUserSeeder::class,
        ]);


        // \App\Models\CentralUser::factory(3)->create();

        $select_rundom_phone = User::select('phone')
            ->inRandomOrder()
            ->first();
        $this->command->info('✅ Roles and permissions seeded successfully. phone test login--->  '.$select_rundom_phone['phone'] .'  Pass: password');

    }
}
