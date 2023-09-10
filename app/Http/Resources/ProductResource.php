<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'code' => $this->code,
            'category_id' => $this->category_id,
            'status_id' => $this->status_id,
            'brand_id' => $this->brand_id,
            'tax' => $this->tax,
            'tax_type' => $this->tax_type,
            'description' => $this->description,
            'type' => $this->type,
            'cost' => $this->cost,
            'price' => $this->price,
            'unit_id' => $this->unit_id,
            'sale_unit_id' => $this->sale_unit_id,
            'purchase_unit_id' => $this->purchase_unit_id,
            'stok_alert' => $this->stok_alert,
            'has_serial' => $this->has_serial,
            'not_for_sale' => $this->not_for_sale,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
