<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseStatuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PurchaseStatues::factory(3)->create();
    }
}
