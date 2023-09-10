<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'country' => $this->country,
            'city' => $this->city,
            'email' => $this->email,
            'zipcode' => $this->zipcode,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
