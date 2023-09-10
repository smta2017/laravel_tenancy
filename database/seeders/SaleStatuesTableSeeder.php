<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SaleStatuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\SaleStatues::factory(3)->create();
    }
}
