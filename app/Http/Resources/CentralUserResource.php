<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CentralUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'global_id' => $this->global_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
            // 'created_at' => $this->created_at, // timestamps are false in model
            // 'updated_at' => $this->updated_at,
        ];
    }
}
