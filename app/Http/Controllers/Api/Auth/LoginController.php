<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\LoginTenantRequest;
use App\Models\CentralUser;
use Illuminate\Support\Facades\Auth;

class LoginController extends AppBaseController
{

    public function login(LoginTenantRequest $request)
    {
        // Attempt to log in the CentralUser using the credentials
        if (Auth::attempt($request->only('email', 'password'))) {

            $central_user = CentralUser::find($request->user()->id);
            $tenant = $central_user->Tenants->first();
            tenancy()->initialize($tenant);
            Auth::attempt($request->only('email', 'password'));
            $sanctum_token = $request->user()->createToken('api-login-token')->plainTextToken;

            $subdomain = $tenant->id;
            // Return a JSON response with the token and user details
            return  $this->sendResponse([
                "token" => $sanctum_token,
                "tenant_id" => $subdomain,
                "domain" => "$subdomain.saas.test",
                "redirectUrl" => "http://$subdomain.saas.test"
            ], 'Tenant Login successfuly');
        } else {
            // Return an error response if the login attempt failed
            return $this->sendError('Invalid credentials',401);
        }
    }
}
