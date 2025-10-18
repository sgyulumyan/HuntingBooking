<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\HuntingBooking
 */
class HuntingBookingResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'tour_name' => $this->tour_name,
            'hunter_name' => $this->hunter_name,
            'date' => $this->date?->toDateString(),
            'participants_count' => $this->participants_count,
            'guide' => new GuideResource($this->whenLoaded('guide')),
        ];
    }
}
