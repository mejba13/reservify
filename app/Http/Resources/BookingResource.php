<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->full_name,
                'email' => $this->customer->email,
                'phone' => $this->customer->phone,
            ],
            'provider' => [
                'id' => $this->provider->id,
                'name' => $this->provider->name,
            ],
            'service' => [
                'id' => $this->service->id,
                'name' => $this->service->name,
                'duration_minutes' => $this->service->duration_minutes,
                'price' => $this->service->price,
            ],
            'start_time' => $this->start_time->toIso8601String(),
            'end_time' => $this->end_time->toIso8601String(),
            'status' => $this->status,
            'notes' => $this->notes,
            'can_be_cancelled' => $this->canBeCancelled(),
            'can_be_rescheduled' => $this->canBeRescheduled(),
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
