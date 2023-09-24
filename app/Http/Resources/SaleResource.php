<?php

namespace App\Http\Resources;

use App\Http\Resources\Mini\UserResource;
use Carbon\Carbon;
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
            'grand_total' => $this->grand_total,
            'tax_net' => $this->tax_net,
            'the_date' => $this->the_date,
            'discount' => $this->discount,
            'notes' => $this->notes,
            'shipping' => $this->shipping,
            'status_id' => $this->status_id,
            'customer' => $this->customer,
            'warehouse' => $this->warehouse,
            'tax_rate' => $this->tax_rate,
            'created_by' => new UserResource($this->createdBy),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i'), // Format created_at
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i'), // Format updated_at
            'details' => SaleDetailResource::collection( $this->saleDetails )
        ];
    }
}