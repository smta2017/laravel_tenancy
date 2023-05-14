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
            $this->storePhoneSession($request, false);
        }
        $this->storePhoneSession($request, true);
        return $this->sendSuccess($sender['message']);
    }

    public function createTenant(Request $request)
    {
        if (session($request->phone)) {
            try {
                $central_domain = config('tenancy.central_domains')[(env('APP_ENV') == 'local') ? 1 : 0];;
                $tenant = Tenant::create( $request->all() );
                $tenant->domains()->create(['domain' => $request->id . '.' . $central_domain]);
                $this->storePhoneSession($request, false);
                return $this->sendResponse($tenant, 'Tenant Has ben created');
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
