<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $owner = $this->users->first();
        $domain = $this->domains->first()?->domain;
        $subscription = $this->planSubscription('main');
        $plan = $subscription?->plan;

        return [
            'id' => $this->id,
            'tenant_id' => $this->id,
            'domain' => $domain,
            'owner_id' => $owner?->id,
            'owner_name' => $owner?->name,
            'owner_email' => $owner?->email,
            'owner_phone' => $owner?->phone,
            'email' => $owner?->email,
            'phone' => $owner?->phone,
            'address' => $this->address,
            'plan_id' => $plan?->id,
            'plan_name' => $plan?->name,
            'is_active' => true, // You might have a status column
            'created_at' => $this->created_at,
        ];
    }
}
