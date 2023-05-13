<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\SMS\OTPVerify;
use App\Http\Controllers\AppBaseController;
use App\Models\Tenant;
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
        }
        return $this->sendSuccess($sender['message']);
    }

    public function register(Request $request)
    {
        $central_domain = \config('tenancy.central_domains')[0];
        $tenant = Tenant::create(['id' => $request->tenant_id]);
        $tenant->domains()->create(['domain' => $request->tenant_id . '.' . $central_domain]);

        return $tenant;
    }
}
