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
            DropDBSeeder::class,
            PlansSeeder::class,
            TenantsSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            SubscriptionsSeeder::class,

            CaseStatesTableSeeder::class,
            CaseTypesTableSeeder::class,
            
            BandsTableSeeder::class,
            ContractsTableSeeder::class,
            ContractBandsTableSeeder::class,
            
            LitigationAuthorityTypesTableSeeder::class,
            LitigationLevelsTableSeeder::class,
            
            TheCasesTableSeeder::class,
            
            
            AttributeOpponentsTableSeeder::class,
            ClientsTableSeeder::class,

            CaseDetailsTableSeeder::class,
            CaseDetailsClientsTableSeeder::class,

            EventStatesTableSeeder::class,
            EventTypesTableSeeder::class,
            CaseDetailEventsTableSeeder::class,
            // TheCasesTableSeeder::class,
            // TesureSeeder::class,
            // CentralUserSeeder::class,
        ]);


        // \App\Models\CentralUser::factory(3)->create();

        // $select_rundom_phone = User::select('phone')
        //     ->inRandomOrder()
        //     ->first();
        // $this->command->info('✅ Roles and permissions seeded successfully. phone test login--->  '.$select_rundom_phone['phone'] .'  Pass: password');

    }
}
