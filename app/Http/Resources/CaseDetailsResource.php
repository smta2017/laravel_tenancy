<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseDetailsResource extends JsonResource
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
            'case_id' => $this->case_id,
            'litigation_level_id' => $this->litigation_level_id,
            'case_number' => $this->case_number,
            'circle' => $this->circle,
            'floor' => $this->floor,
            'hall' => $this->hall,
            'secretary' => $this->secretary,
            'litigation_authority_id' => $this->litigation_authority_id,
            'gedge' => $this->gedge,
            'is_active' => $this->is_active,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
