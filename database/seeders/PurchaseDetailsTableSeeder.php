<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PurchaseDetails::factory(3)->create();

    }
}
