<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'grand_total' => $this->grand_total,
            'tax_net' => $this->tax_net,
            'the_date' => $this->the_date,
            'discount' => $this->discount,
            'notes' => $this->notes,
            'shipping' => $this->shipping,
            'status_id' => $this->status_id,
            'supplier' => $this->supplier,
            'warehouse' => $this->warehouse,
            'tax_rate' => $this->tax_rate,
            'created_by' => $this->createdBy,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'), // Format created_at
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'), // Format updated_at
            'details' => PurchaseDetailsResource::collection( $this->purchaseDetails ),
        ];
    }
}
