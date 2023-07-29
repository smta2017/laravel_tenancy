<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\SMS\OTPVerify;
use App\Http\Controllers\AppBaseController;
use App\Models\CentralUser;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends AppBaseController
{

    public function sendotp(Request $request)
    {
        $sender = OTPVerify::sendOTP($request);
        if (!$sender['success']) {
            return $this->sendError($sender['message']);
        }
        return $this->sendSuccess($sender['message']);
    }

    public function verifyotp(Request $request)
    {
        $sender = OTPVerify::verifyOTP($request);
        if (!$sender['success']) {
            return $this->sendError($sender['message']);
            $this->storePhoneSession($request, false);
        }
        $this->storePhoneSession($request, true);
        return $this->sendSuccess($sender['message']);
    }

    public function createTenant(Request $request)
    {
        if (\env("APP_ENV") == "local" || session($request->phone)) {
            try {
                $central_domain = config('tenancy.central_domains')[(env('APP_ENV') == 'local') ? 1 : 0];
                $random_time = substr(\Carbon\Carbon::now()->timestamp, -4);
                ($request->id == "") ? $request['id'] = \Str::random(3) . "_" . $random_time : '';

                //Create tenant
                $tenant = Tenant::create($request->all());

                //Create tenant domain
                $tenant->domains()->create(['domain' => $request->id . '.' . $central_domain]);

                $this->storePhoneSession($request, false);
                // ========================================================================
                // Collect user info
                $user_info = [
                    'role' => 'superadmin',
                    'global_id' => (string) \Str::uuid(),
                    'name' => $random_time . "_" . $request->name,
                    'email' => $random_time . "_" . $request->email,
                    'password' => \Hash::make('password')
                ];

                $user = CentralUser::create($user_info);

                tenancy()->initialize($tenant);

                // Create the same user in tenant DB
                $user = User::create($user_info);
                //--------------------------------------------------------
                // Collect user info
                $user_info2 = [
                    'role' => 'superadmin',
                    'global_id' => (string) \Str::uuid(),
                    'name' => $random_time . "2_" . $request->name,
                    'email' => $random_time . "2_" . $request->email,
                    'password' => \Hash::make('password')
                ];

                $user2 = CentralUser::create($user_info2);

                tenancy()->initialize($tenant);

                // Create the same user in tenant DB
                $user2 = User::create($user_info2);

                // ========================================================================
                \Auth::login($user);

                $tenant['token'] =  auth()->user()->createToken('first-token')->plainTextToken;

                return $this->sendResponse($tenant, 'Tenant Has created as successfuly');
            } catch (\Throwable $th) {
                return $this->sendError($th->getMessage());
            }
        }
        return $this->sendError('No verified phone found');
    }
    public function storePhoneSession(Request $request, bool $status)
    {
        session([$request->phone => $status]);
    }
}
