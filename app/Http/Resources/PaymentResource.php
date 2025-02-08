<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d'),
            'court_hours' => $this->court_hours,
            'court_rate' => $this->court_rate,
            'shuttle_num' => $this->shuttle_num,
            'shuttle_rate' => $this->shuttle_rate,
            'total_cost' => $this->total_cost,
            'payment_per_person' => $this->payment_per_person,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
