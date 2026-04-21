<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractBandResource extends JsonResource
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
            'contract_id' => $this->contract_id,
            'band_id' => $this->band_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
