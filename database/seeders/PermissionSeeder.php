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
        // $guard_name = 'web';

        $permissions = [
            'users.list',
            'users.create',
            'users.edit',
            'users.delete',
            'cases.list',
            'cases.create',
            'cases.edit',
            'cases.delete',
            'settings.access',
        ];



        foreach (Tenant::all() as $tenant) {
            tenancy()->initialize($tenant);
            foreach ($permissions as $perm) {
                Permission::firstOrCreate(['name' => $perm]);
            }

            // Define roles and assign permissions
            $roles = [
                'Admin' => $permissions, // all permissions
                'Manager' => [
                    'users.list',
                    'cases.list',
                    'cases.create'
                ],
                'Editor' => [
                    'users.list',
                    'cases.list',
                    'cases.edit'
                ],
            ];

            foreach ($roles as $roleName => $rolePermissions) {
                $role = Role::firstOrCreate([
                    'name' => $roleName
                ]);

                $role->syncPermissions($rolePermissions);
            }
        }
    }
}
