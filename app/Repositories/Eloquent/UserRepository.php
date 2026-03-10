<?php

namespace App\Repositories\Eloquent;

use App\Models\CentralUser;
use App\Models\User;
use App\Repositories\Contracts\IUser;
use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRepository extends BaseRepository implements IUser
{
    protected $fieldSearchable = [
        'name'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return User::class;
    }

    public function generateTenantAdmin($tenant, $request)
    {
        $permissions = config('permissions.role_mapping.Admin');

        $user_info = [
            'global_id' => (string) \Str::uuid(),
            'name' => $tenant->id,
            'email' =>  $request->email,
            'phone' =>  $request->phone,
            'password' => \Hash::make($request['password'] ?? 'password'),
            'is_active' => true,
            'account_verified_at' => \Carbon\Carbon::now(),
        ];

        CentralUser::create($user_info);

        tenancy()->initialize($tenant);

        $user = User::create($user_info);

        // Create permissions correctly
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Create role
        $role = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($permissions);

        $user->assignRole('Admin');

        return $user;
    }
}
