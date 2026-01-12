<?php

namespace App\Http\Controllers\API\Central;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TenantResource;
use App\Models\CentralUser;
use App\Models\Tenant;
use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravelcm\Subscriptions\Models\Plan;
use Stancl\Tenancy\Facades\Tenancy;

class TenantController extends AppBaseController
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(): JsonResponse
    {
        $tenants = Tenant::with(['domains', 'users'])->get();
        return $this->sendResponse(
            TenantResource::collection($tenants),
            'Tenants retrieved successfully'
        );
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'tenant_id' => 'required|unique:tenants,id',
            'domain' => 'nullable|unique:domains,domain',
            'owner_name' => 'required',
            'owner_email' => 'required|email|unique:central_users,email',
            'owner_password' => 'required|min:6',
        ]);

        try {
            DB::beginTransaction();

            $central_domain = config('tenancy.central_domains')[0];
            $domainName = $request->domain ?: ($request->tenant_id . '.' . $central_domain);

            $tenant = Tenant::create([
                'id' => $request->tenant_id,
                'address' => $request->address,
            ]);

            $tenant->domains()->create([
                'domain' => $domainName
            ]);

            if ($request->plan_id) {
                $plan = Plan::find($request->plan_id);
                if ($plan) {
                    $tenant->newPlanSubscription('main', $plan);
                }
            }

            // Generate Admin User
            $request->merge([
                'name' => $request->owner_name,
                'email' => $request->owner_email,
                'phone' => $request->owner_phone,
                'password' => $request->owner_password,
            ]);

            $this->userRepository->generateTenantAdmin($tenant, $request);

            DB::commit();

            return $this->sendResponse(new TenantResource($tenant->load(['domains', 'users'])), 'Tenant created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function update($id, Request $request): JsonResponse
    {
        $tenant = Tenant::find($id);
        if (!$tenant) {
            return $this->sendError('Tenant not found');
        }

        $request->validate([
            'owner_name' => 'required',
            'owner_email' => 'required|email',
        ]);

        try {
            DB::beginTransaction();

            $tenant->update([
                'address' => $request->address,
            ]);

            if ($request->plan_id) {
                $plan = Plan::find($request->plan_id);
                if ($plan) {
                    // Update or create subscription
                    $subscription = $tenant->planSubscription('main');
                    if ($subscription) {
                        $tenant->planSubscription('main')->changePlan($plan);
                    } else {
                        $tenant->newPlanSubscription('main', $plan);
                    }
                }
            }

            // Update owner if needed
            $owner = $tenant->users()->first();
            if ($owner) {
                $owner->update([
                    'name' => $request->owner_name,
                    'email' => $request->owner_email,
                    'phone' => $request->owner_phone,
                ]);

                // Also update in tenant DB
                tenancy()->initialize($tenant);
                $tenantUser = User::where('global_id', $owner->global_id)->first();
                if ($tenantUser) {
                    $tenantUser->update([
                        'name' => $request->owner_name,
                        'email' => $request->owner_email,
                        'phone' => $request->owner_phone,
                    ]);
                }
                tenancy()->end();
            }

            DB::commit();
            return $this->sendResponse(new TenantResource($tenant->load(['domains', 'users'])), 'Tenant updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        $tenant = Tenant::find($id);
        if (!$tenant) {
            return $this->sendError('Tenant not found');
        }

        try {
            // Delete domains first
            $tenant->domains()->delete();
            // Delete tenant (this will also delete the database if configured)
            $tenant->delete();

            return $this->sendSuccess('Tenant deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
