<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "description" => $this->description,
            "timezone" => $this->timezone,
            "trial_ends_at" => $this->trial_ends_at,
            "starts_at" => $this->starts_at,
            "ends_at" => $this->ends_at,
            "cancels_at" => $this->cancels_at,
            "canceled_at" => $this->canceled_at,
            "created_at" => $this->created_at,
            "plan" => [
                "id" => $this->plan->id,
                "name" => $this->plan->name,
                "slug" => $this->plan->slug,
                "description" => $this->plan->description,
            ],
            "features" => $this->plan->features->map(function ($feature) {
                $usage = $this->usage->where('feature_id', $feature->id)->first();
                return [
                    "id" => $feature->id,
                    "name" => $feature->name,
                    "slug" => $feature->slug,
                    "value" => $feature->value,
                    "used" => $usage ? $usage->used : 0,
                    "description" => $feature->description,
                ];
            }),

        ];
    }
}
