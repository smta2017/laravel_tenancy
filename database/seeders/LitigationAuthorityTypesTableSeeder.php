<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class LitigationAuthorityTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Tenant::all() as $tenant) {
            tenancy()->initialize($tenant);
            \App\Models\LitigationAuthorityType::factory()->count(3)->create();
        }
    }
}
