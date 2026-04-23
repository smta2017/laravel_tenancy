<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseDetailEventResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'subject' => $this->subject,
            'notes' => $this->notes,
            'type_id' => $this->type_id,
            'status_id' => $this->status_id,
            'created_by' => $this->created_by,
            'assigned_to' => $this->assigned_to,
            'closed_by' => $this->closed_by,
            'is_private' => $this->is_private,
            'client_access' => $this->client_access,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => new EventTypeResource($this->whenLoaded('type')),
            'status' => new EventStateResource($this->whenLoaded('status'))
        ];
    }
}
