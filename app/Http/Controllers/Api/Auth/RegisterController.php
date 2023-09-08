<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\CustomException;
use App\Helpers\Helper;
use App\Helpers\SMS\OTPVerify;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateTenantRequest;
use App\Jobs\SendTenantVerificationEmail;
use App\Models\CentralUser;
use App\Models\Tenant;
use App\Models\TenantModel;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends AppBaseController
{
    use Helper;

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

    public function createTenant(CreateTenantRequest $request)
    {
        if (!session($request->phone) && !Helper::TestedEnv()) {
            return $this->sendError('Phone Number is not verified.', 422);
        }

        $central_domain = config('tenancy.central_domains')[(Helper::TestedEnv()) ? 1 : 0];

        //Create tenant
        $tenant = Tenant::create($request->all());

        //Create tenant domain
        $tenant->domains()->create(['domain' => $request->id . '.' . $central_domain]);

        $this->storePhoneSession($request, false);
        // ========================================================================

        $admin = $this->generateTenantAdmin($request, $tenant);

        // Job Send the verification email to tenant
        // SendTenantVerificationEmail::dispatch($admin)->onQueue('tenant_verify_email')->delay(now()->subSeconds(5));

        // $last_user = $this->generateTenantUsers($request, $tenant);

        // ========================================================================
        \Auth::login($admin);

        $tenant['token'] =  auth()->user()->createToken('first-token')->plainTextToken;

        return $this->sendResponse($tenant, 'Tenant has created as successfuly');

        return $this->sendError('No verified phone found');
    }

    public function storePhoneSession(Request $request, bool $status)
    {
        session([$request->phone => $status]);
    }

    public function generateTenantAdmin($request, $tenant)
    {

        $user_info = [
            'global_id' => (string) \Str::uuid(),
            'name' => 'admin',
            'email' =>  $request->email,
            'password' => \Hash::make($request['password'] ?? 'password')
        ];

        CentralUser::create($user_info);

        tenancy()->initialize($tenant);

        // Create the same user in tenant DB
        $user = User::create($user_info);

        return $user;
    }

    public function generateTenantUsers($request, $tenant)
    {
        for ($i = 1; $i <= 3; $i++) {
            $user_info = [
                'global_id' => (string) \Str::uuid(),
                'name' => $tenant['id'] . $i . "_" . $request->name,
                'email' => $tenant['id'] . $i . "_" . $request->email,
                'password' => \Hash::make('password')
            ];

            CentralUser::create($user_info);

            tenancy()->initialize($tenant);

            // Create the same user in tenant DB
            $user = User::create($user_info);
        }
        return $user;
    }
}
