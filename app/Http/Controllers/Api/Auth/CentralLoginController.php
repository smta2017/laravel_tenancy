<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\LoginTenantRequest;
use Illuminate\Support\Facades\Auth;

class CentralLoginController extends AppBaseController
{
    public function login(LoginTenantRequest $request)
    {
        //centraluser login
        $attempt_type = is_numeric($request->identifier) ? 'phone' : 'email';

        // Pre-check: block tenant users before authenticating
        $user = \App\Models\CentralUser::where($attempt_type, $request->identifier)->first();

        if ($user) {
            $isTenantUser = \DB::table('tenant_users')
                ->where('global_user_id', $user->global_id)
                ->exists();

            if ($isTenantUser) {
                return $this->sendError('This account is a tenant user. Please use tenant login.', 403);
            }
        }

        if (Auth::attempt([$attempt_type => $request->identifier, 'password' => $request->password])) {
            $current_user = Auth::user();
            $sanctum_token = $current_user->createToken('api-login-token')->plainTextToken;

            return  $this->sendResponse([
                "user" => $current_user,
                "token" => $sanctum_token,
            ], 'Central Login successfuly');
        }

        return $this->sendError('Invalid credentials', 401);
    }
}
