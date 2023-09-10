<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'GrandTotal' => $this->GrandTotal,
            'TaxNet' => $this->TaxNet,
            'the_date' => $this->the_date,
            'discount' => $this->discount,
            'notes' => $this->notes,
            'shipping' => $this->shipping,
            'status_id' => $this->status_id,
            'customer_id' => $this->customer_id,
            'warehouse_id' => $this->warehouse_id,
            'tax_rate' => $this->tax_rate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
