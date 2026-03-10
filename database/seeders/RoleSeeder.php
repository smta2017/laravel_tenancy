<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
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

            // Create roles and sync their matching permissions
            foreach ($rolesData as $roleName => $rolePermissions) {
                $role = Role::firstOrCreate([
                    'name' => $roleName,
                    'guard_name' => 'web'
                ]);

                $role->syncPermissions($rolePermissions);
            }

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
