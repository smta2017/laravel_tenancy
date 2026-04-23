<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class EventStatesTableSeeder extends Seeder
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
            \App\Models\EventState::factory()->count(3)->create();
        }
    }
}
