<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class CaseDetailEventsTableSeeder extends Seeder
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
            \App\Models\CaseDetailEvent::factory()->count(3)->create();
        }
    }
}
