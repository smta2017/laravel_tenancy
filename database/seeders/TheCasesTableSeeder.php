<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\TheCase;
use Illuminate\Database\Seeder;

class TheCasesTableSeeder extends Seeder
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
            TheCase::factory()->count(10)->create();
        }
    }
}
