<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\TenantModel;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use ResponseTrait;

    public function verify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return $this->sendError("Invalid/Expired url provided.", 401);
        }

        $tenant = Tenant::findOrFail($user_id);

        if (!$tenant->hasVerifiedEmail()) {
            $tenant->markEmailAsVerified();
        }
        return $this->sendSuccess("Email verified.");

        return redirect()->to('/');
    }

    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return $this->sendError("Email already verified.", 400);
        }

        auth()->user()->sendEmailVerificationNotification();

        return $this->sendSuccess("Email verification link sent on your email id");
    }
}
