<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\SMS\OTPVerify;
use App\Http\Controllers\Controller;
use App\Models\CentralUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function sendResetPhoneOTP(Request $request){
        
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['identifier' => 'required']);
        
        $identifier_type = is_numeric($request->identifier) ? 'phone' : 'email';

        if ($identifier_type === 'phone') {
            $request['phone'] = $request->identifier;
            OTPVerify::sendOTP($request);
            return response()->json(['message' => 'OTP sent to your phone'], 200);
        } else {

            $status = Password::sendResetLink(
                $request->only('email')
            );
        }

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email'], 200)
            : response()->json(['message' => 'Unable to send reset link'], 400);
    }
    

    public function resetPassword(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // $token = $this->getRequestToken($request->token);
        $identifier_type = is_numeric($request->identifier) ? 'phone' : 'email';

        if ($identifier_type === 'phone') {
            $request['phone'] = $request->identifier;
            $status = OTPVerify::verifyOTP($request);
            if (!$status['status']) {
                return response()->json(['message' => $status['message']], 400);
            }
            $central_user = CentralUser::where('phone', $request->identifier)->first();
            if (!$central_user) {
                return response()->json(['message' => 'User not found'], 404);
            }   
            $tenant = $central_user->Tenants->first();
            tenancy()->initialize($tenant);
            $user = User::where('phone', $request->identifier)->first();
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => \Str::random(60),
            ])->save();
            return response()->json(['message' => 'Password reset successfully'], 200);
        } else {
            $status = Password::reset(
                $request->only('identifier', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
    
                    $central_user = CentralUser::whereGlobalId($user->global_id)->first();
                    $tenant = $central_user->Tenants->first();
                    tenancy()->initialize($tenant);
    
                    $user = User::whereGlobalId($central_user->global_id)->first();
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => \Str::random(60),
                    ])->save();
    
                    // You can add additional actions here if needed, like logging in the user.
                }
            );
        }

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully'], 200)
            : response()->json(['message' => 'Unable to reset password'], 400);
    }

    public function getRequestToken($url)
    {
        // Parse the URL
        $parsedUrl = parse_url($url);

        // Extract the query string
        $query = $parsedUrl['query'];

        // Parse the query string into an array
        parse_str($query, $queryParameters);

        // Extract the 'token' parameter
        $token = $queryParameters['token'];

        return $token;
    }
}
