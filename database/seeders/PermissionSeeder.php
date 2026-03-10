<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\Tenant;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allPermissions = config('permissions.all');

        foreach (Tenant::all() as $tenant) {
            tenancy()->initialize($tenant);

            // Ensure all permissions exist
            foreach ($allPermissions as $perm) {
                Permission::firstOrCreate([
                    'name' => $perm,
                    'guard_name' => 'web'
                ]);
            }
            \App\Models\User::factory()->count(3)->create();
        }
    }
}
