<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppBaseController;
use App\Models\CentralUser;
use App\Models\PersonalAccessTokens;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends AppBaseController
{

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Attempt to log in the user using the credentials
        if (Auth::attempt($request->only('email', 'password'))) {
            $central_user = CentralUser::find($request->user()->id);
            $tenant = $central_user->Tenants->first(); // Replace this with your way of fetching the tenant.
            tenancy()->initialize($tenant);
            Auth::attempt($request->only('email', 'password'));
            $sanctum_token = $request->user()->createToken('api-login-token')->plainTextToken;

            $subdomain = $tenant->id; // Replace this with your way of fetching the tenant's primary domain.
            // Return a JSON response with the token and user details
            return response()->json([
                "token" => $sanctum_token,
                "tenant_id" => $subdomain,
                "domain" => "$subdomain.saas.test",
                "redirectUrl" => "http://$subdomain.saas.test"
            ]);
        } else {
            // Return an error response if the login attempt failed
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
