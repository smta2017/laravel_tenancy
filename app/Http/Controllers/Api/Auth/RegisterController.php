<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\Helper;
use App\Helpers\SMS\OTPVerify;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateTenantRequest;
use App\Models\CentralUser;
use App\Models\ComfirmedPhone;
use Illuminate\Support\Facades\Notification;
use App\Models\Tenant;
use App\Models\Tesure;
use App\Models\User;
use App\Notifications\NewTenantNotification;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravelcm\Subscriptions\Models\Plan;
use Stancl\Tenancy\Facades\Tenancy;


class RegisterController extends AppBaseController
{
    use Helper;

    public $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendotp(Request $request)
    {
        $sender = OTPVerify::sendOTP($request);
        if (!$sender['status']) {
            return $this->sendError($sender['message']);
        }
        return $this->sendSuccess('OTP sent success!');
    }

    public function validateRegister(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:tenants,id',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
        ]);

        return $this->sendSuccess('Validation passed');
    }


    public function verifyotp(Request $request)
    {
        $sender = OTPVerify::verifyOTP($request);
        if (!$sender['status']) {
            return $this->sendError($sender['message']);
        }
        // $this->storeConfirmedPhone($request->phone);
        return $this->sendSuccess('OTP success verify check!');
    }

    public function createTenant(CreateTenantRequest $request)
    {
        // $phone_check = $this->getConfirmedPhone($request->phone);
        // if (!$phone_check && !Helper::TestedEnv()) {
        //     return $this->sendError('Phone Number is not verified.', 422);
        // }

        // If phone does NOT start with +20
        if (!\Str::startsWith($request->input('phone'), '+2')) {
            $request->merge(['phone' => '+2' . ltrim($request->input('phone'), '+')]);
        }

        $sender = OTPVerify::verifyOTP($request);

        if (!$sender['status']) {
            return $this->sendError($sender['message']);
        }

        try {
            DB::beginTransaction();
            $central_domain = config('tenancy.central_domains')[Helper::TestedEnv() ? 1 : 0];

            $rr = DB::getDefaultConnection(); // mysql

            Tenancy::central(function () use ($request, $central_domain, &$tenant, &$plan) {

                $plan = Plan::first(); // mysql

                $tenant = Tenant::create($request->all()); // mysql

                $tenant->domains()->create([
                    'domain' => $request->input('id') . '.' . $central_domain
                ]);

                // Subscribe the tenant to the plan while in the central context
                if ($plan) {
                    $tenant->newPlanSubscription('main', $plan);
                }
                // notify central users
                Notification::send(CentralUser::find(1), new NewTenantNotification("New tenant added", $tenant));

            }); // ← tenancy context restored automatically

            // ========================================================================

            $admin = $this->userRepository->generateTenantAdmin($tenant, $request);

            // Job Send the verification email to tenant
            // SendTenantVerificationEmail::dispatch($admin)->onQueue('tenant_verify_email')->delay(now()->subSeconds(5));

            // $last_user = $this->generateTenantUsers($request, $tenant);

            // ========================================================================
            \Auth::login($admin);
            $tenant['token'] =  auth()->user()->createToken('first-token')->plainTextToken;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError($th->getMessage());
        }


        DB::beginTransaction();

        return $this->sendResponse($tenant, 'Tenant has created as successfuly');
    }

    public function storeConfirmedPhone($phone, bool $status = true)
    {
        $phone =  ComfirmedPhone::updateOrCreate(
            ['phone' => $phone]
        );
    }

    public function getConfirmedPhone($phone)
    {
        $phone = ComfirmedPhone::where('phone', $phone)->first();
        if ($phone) {
            return $phone;
        }
        return false;
    }

    // public function generateTenantAdmin($request, $tenant)
    // {

    //     $user_info = [
    //         'global_id' => (string) \Str::uuid(),
    //         'name' => 'admin',
    //         'email' =>  $request->email,
    //         'phone' =>  $request->phone,
    //         'password' => \Hash::make($request['password'] ?? 'password'),
    //         'is_active' => true,
    //         'account_verified_at' => \Carbon\Carbon::now(),
    //     ];

    //     CentralUser::create($user_info);

    //     tenancy()->initialize($tenant);

    //     // Create the same user in tenant DB
    //     $user = User::create($user_info);

    //     // Create role and assign permission


    //     $user->assignRole('Admin');

    //     return $user;
    // }

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
