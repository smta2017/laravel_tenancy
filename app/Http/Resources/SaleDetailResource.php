<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleDetailResource extends JsonResource
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
            'sale_id' => $this->sale_id,
            'name' => $this->name,
            'discountNet' => $this->discountNet,
            'discount_Method' => $this->discount_Method,
            'discount' => $this->discount,
            'net_cost' => $this->net_cost,
            'unit_cost' => $this->unit_cost,
            'code' => $this->code,
            'del' => $this->del,
            'no_unit' => $this->no_unit,
            'product_id' => $this->product_id,
            'purchase_unit_id' => $this->purchase_unit_id,
            'quantity' => $this->quantity,
            'stock' => $this->stock,
            'subtotal' => $this->subtotal,
            'tax_type' => $this->tax_type,
            'tax_percent' => $this->tax_percent,
            'taxe' => $this->taxe,
            'unitPurchase' => $this->unitPurchase,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
