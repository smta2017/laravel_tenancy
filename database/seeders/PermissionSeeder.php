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
        $rolesData = config('permissions.role_mapping');

        foreach (Tenant::all() as $tenant) {
            tenancy()->initialize($tenant);

            // Ensure all permissions exist
            foreach ($allPermissions as $perm) {
                Permission::firstOrCreate([
                    'name' => $perm,
                    'guard_name' => 'web'
                ]);
            }

            // Create roles and sync their matching permissions
            foreach ($rolesData as $roleName => $rolePermissions) {
                $role = Role::firstOrCreate([
                    'name' => $roleName,
                    'guard_name' => 'web'
                ]);

                $role->syncPermissions($rolePermissions);
            }

            // Assign 'Admin' role to the last user of this tenant
            $users = \App\Models\User::get();
            for ($i = 0; $i < count($users); $i++) {
                if ($i == 0) {
                    $users[$i]->assignRole('Admin');
                } elseif ($i == 1) {
                    $users[$i]->assignRole('Manager');
                } elseif ($i == 2) {
                    $users[$i]->assignRole('Editor');
                }
            }
        }
    }
}
