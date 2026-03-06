<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\LoginTenantRequest;
use App\Models\CentralUser;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends AppBaseController
{



    public function login(LoginTenantRequest $request)
    {
        // Attempt to log in the CentralUser using the credentials
        $attempt_type = is_numeric($request->identifier) ? 'phone' : 'email';
        if (Auth::attempt([$attempt_type => $request->identifier, 'password' => $request->password])) {
            $central_user = CentralUser::find($request->user()->id);
            $tenant = $central_user->Tenants->first();

            // $subscription = $tenant->planSubscription('main')->with('plan')->first();

            tenancy()->initialize($tenant);
            Auth::attempt([$attempt_type => $request->identifier, 'password' => $request->password]);
            /** @var User $tenant_user */
            $tenant_user = Auth::user();

            // Check if the user's account is verified
            if (!$tenant_user->account_verified_at) {
                return $this->sendError('Your account is not verified, please verify it first.', 403);
            }

            // Check if the user is active
            if (!$tenant_user->is_active) {
                return $this->sendError('Your account is not active, please activate it first.', 403);
            }

            $sanctum_token = $request->user()->createToken('api-login-token')->plainTextToken;

            // Return a JSON response with the token and user details
            return $this->sendUserResponse($tenant_user, 'Tenant Login successfuly', $sanctum_token);
        } else {
            // Return an error response if the login attempt failed
            return $this->sendError('Invalid credentials', 401);
        }
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

        return $this->sendUserResponse($user, 'User retrieved successfully');
    }
}
