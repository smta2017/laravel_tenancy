<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\LoginTenantRequest;
use App\Models\CentralUser;
use Illuminate\Support\Facades\Auth;
use Laravelcm\Subscriptions\Models\Subscription;
use App\Http\Resources\SubscriptionResource;

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

            $subscription = Subscription::ofSubscriber($tenant)->with('plan')->first();

            tenancy()->initialize($tenant);
            Auth::attempt([$attempt_type => $request->identifier, 'password' => $request->password]);
            $current_user = Auth::user();

            // Check if the user's account is verified
            if (!is_null($current_user->account_verified_at) == false) {
                return $this->sendError('Your account is not verified, please verify it first.', 403);
            }

            // Check if the user is active
            if ($current_user->is_active == false) {
                return $this->sendError('Your account is not active, please activate it first.', 403);
            }

            $sanctum_token = $request->user()->createToken('api-login-token')->plainTextToken;
            $subdomain = $tenant->id;

            // return all permissions in all roles
            $permissions = $current_user->roles->pluck('permissions')->flatten();
            $current_user->permissions = $permissions;
            $current_user->load('roles');



            // $current_user->load('roles.permissions', 'permissions');

            // Return a JSON response with the token and user details
            return  $this->sendResponse([
                "user" => $current_user,
                "token" => $sanctum_token,
                "tenant_id" => $subdomain,
                "subscription" => new SubscriptionResource($subscription),
                "domain" => "$subdomain.saas.test",
                "redirectUrl" => "http://$subdomain.saas.test"
            ], 'Tenant Login successfuly');
        } else {
            // Return an error response if the login attempt failed
            return $this->sendError('Invalid credentials', 401);
        }
    }
}
