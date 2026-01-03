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

        return [
            'tenant_id' => $this->id,
            'domain' => $domain,
            'owner_name' => $owner?->name,
            'email' => $owner?->email,
            'phone' => $owner?->phone,
            'address' => $this->address,
            'created_at' => $this->created_at,
            // 'plan_name' => $this->plan?->name, // If plan relation exists
        ];
    }
}
