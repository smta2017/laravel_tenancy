<?php

namespace App\Http\Controllers\API;

use App\Helpers\SMS\OTPVerify;
use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Contracts\IUser;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Stancl\Tenancy\Features\UserImpersonation;

/**
 * Class UserAPIController
 */
class UserAPIController extends AppBaseController
{
    private $userRepository;

    public function __construct(IUser $userRepo)
    {
        $this->userRepository = $userRepo;
    }



    public function impersonate(Request $request)
    {
        return $impersonate = UserImpersonation::makeResponse($request->token);
    }



    /**
     * Display a listing of the Users.
     * GET|HEAD /users
     */
    public function index(Request $request)
    {
        // $this->checkPermission('users.view');
        
        return User::all();
        $users = $this->userRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     * Store a newly created User in storage.
     * POST /users
     */
    public function store(CreateUserAPIRequest $request): JsonResponse
    {
        $this->checkSubscription();

        $input = $request->all();

        $input['password'] = bcrypt('password');

        $user = $this->userRepository->create($input);

        return $this->sendResponse($user->toArray(), 'User saved successfully');
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     */
    public function update($id, UpdateUserAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse($user->toArray(), 'User updated successfully');
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendSuccess('User deleted successfully');
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     */
    public function me(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        // user with roles and permissions
        $user->load('roles', 'permissions');
        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    public function verifyAccout(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = User::wherePhone($request->phone)->first();

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        if ($user->account_verified_at) {
            return $this->sendError('Your account is already verified', 403);
        }

        $sender = OTPVerify::verifyOTP($request);

        if (!$sender['status']) {
            return $this->sendError('Invalid OTP', 403);
        }

        $user->account_verified_at = now();
        $user->save();

        return $this->sendResponse($user->toArray(), 'Account verified successfully');
    }

    // api url: /api/users/{userId}/assign-role
    public function assignRoles(Request $request, $userId)
    {
        $request->validate([
            'role_ids' => 'required|array',
            'role_ids.*' => 'exists:roles,id',
        ]);

        $user = User::findOrFail($userId);
        $roles = Role::whereIn('id', $request->input('role_ids'))->get();

        $user->syncRoles($roles);

        return $this->sendResponse($user, 'Roles assigned to user successfully');
    }

    public function assignPermissions(Request $request, $userId)
    {
        $request->validate([
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'exists:permissions,id',
        ]);

        $user = User::findOrFail($userId);
        $permissions = Permission::whereIn('id', $request->input('permission_ids'))->get();

        $user->syncPermissions($permissions);

        return $this->sendResponse($user, 'Permissions assigned to user successfully');
    }
}
