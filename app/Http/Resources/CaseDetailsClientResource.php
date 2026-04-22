<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseDetailsClientResource extends JsonResource
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
            'case_details_id' => $this->case_details_id,
            'client_id' => $this->client_id,
            'attribute_opponent_id' => $this->attribute_opponent_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'client' => new ClientResource($this->whenLoaded('client')),
            'attribute_opponent' => new AttributeOpponentResource($this->whenLoaded('attributeOpponent'))
        ];
    }
}
