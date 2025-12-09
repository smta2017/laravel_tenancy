<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    // Index action to list all roles and permissions
    public function index()
    {
        $this->checkPermission('settings.access');

        $roles = Role::all();
        $permissions = Permission::all();

        return $this->sendResponse([
            'roles' => $roles,
            'permissions' => $permissions,
        ], 'Successfully');
    }


    // Create a new role
    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ]);

        $role = Role::create(['name' => $request->input('name'), 'guard_name' => $request->input('guard_name', 'web')]);

        return $this->sendResponse($role, 'Role created successfully', 201);
    }

    // Create a new permission
    public function createPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions',
        ]);

        $permission = Permission::create(['name' => $request->input('name'), 'guard_name' => $request->input('guard_name', 'web')]);

        return $this->sendResponse($permission, 'Permission created successfully', 201);
    }

    // Assign permission(s) to a role
    public function assignPermissionToRole(Request $request, Role $role)
    {
        $permissionIds = $request->input('permission_ids');

        $role->syncPermissions($permissionIds);

        return $this->sendResponse($role, 'Permissions assigned to the role successfully');
    }

    // Remove permission(s) from a role
    public function removePermissionFromRole(Request $request, Role $role)
    {
        $permissionId = $request->input('permission_ids');

        $role->revokePermissionTo($permissionId);

        return $this->sendResponse($role, 'Permissions removed from the role successfully');
    }

    // Delete a role
    public function deleteRole(Role $role)
    {
        $role->delete();

        return $this->sendSuccess('Role deleted successfully');
    }

    // Delete a permission
    public function deletePermission(Permission $permission)
    {
        $permission->delete();

        return $this->sendSuccess('Permission deleted successfully');
    }

    // Show a single role with its permissions
    public function showRole(Role $role)
    {
        $permissions = $role->permissions;

        return $this->sendResponse([
            'role' => $role,
            'permissions' => $permissions,
        ], 'Successfully');
    }

    // Get permissions for a specific role
    public function getRolePermissions(Role $role)
    {
        $permissions = $role->permissions;

        return $this->sendResponse([
            'role' => $role,
            'permissions' => $permissions,
        ], 'Successfully');
    }

    // Get roles for a specific permission
    public function getPermissionRoles(Permission $permission)
    {
        $roles = $permission->roles;

        return $this->sendResponse([
            'permission' => $permission,
            'roles' => $roles,
        ], 'Successfully');
    }
}
