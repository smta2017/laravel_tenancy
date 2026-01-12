<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DropDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('DROP DATABASE IF EXISTS tenant_1_foo');
        DB::statement('DROP DATABASE IF EXISTS tenant_2_bar');
        DB::statement('DROP DATABASE IF EXISTS tenant_3_baz');
        DB::statement('DROP DATABASE IF EXISTS tenant_sameh');
    }
}
