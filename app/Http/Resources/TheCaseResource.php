<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TheCaseResource extends JsonResource
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
            'AutoNumber' => $this->AutoNumber,
            'code' => $this->code,
            'case_number' => $this->case_number,
            'subject' => $this->subject,
            'type_id' => $this->type_id,
            'status_id' => $this->status_id,
            'contract_id' => $this->contract_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'case_details' => CaseDetailsResource::collection($this->whenLoaded('caseDetails'))
        ];
    }
}
