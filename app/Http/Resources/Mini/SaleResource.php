<?php

namespace App\Http\Resources\Mini;

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
            'created_by' => $this->createdBy,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'), // Format created_at
        ];
    }
}
