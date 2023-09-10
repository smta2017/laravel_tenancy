<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SaleDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\SaleDetail::factory(3)->create();
    }
}
