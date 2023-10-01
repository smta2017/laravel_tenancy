<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'quantity' => $this->Inventories->sum('quantity'),
            'category' => $this->category,
            'status_id' => $this->status_id,
            'brand' => $this->brand,
            'tax' => $this->tax,
            'tax_type' => $this->tax_type,
            'description' => $this->description,
            'type' => $this->type,
            'cost' => $this->cost,
            'price' => $this->price,
            'unit_id' => $this->unit_id,
            'unit' => $this->unit,
            'sale_unit' => $this->saleUnit,
            'purchase_unit_id' => $this->purchase_unit_id,
            'stok_alert' => $this->stok_alert,
            'has_serial' => $this->has_serial,
            'not_for_sale' => $this->not_for_sale,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'), // Format created_at
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'), // Format updated_at
            
        ];
    }
}
