<?php

namespace App\Http\Resources\Mini;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'purchase' => $this->purchase,
            'product' => $this->product,
            'supplier' => $this->supplier,
            'warehouse' => $this->warehouse,
            'quantity' => $this->quantity
        ];
    }
}
