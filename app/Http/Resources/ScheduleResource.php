<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
        'id' => $this->resource->id,
        'doctor_id' => $this->resource->doctor_id,
        'date' => $this->resource->date,
        'start_time' => $this->resource->start_time,
        'end_time' => $this->resource->end_time,
        'created_at' => $this->resource->created_at->toDateTimeString(),
        'updated_at' => $this->resource->updated_at->toDateTimeString(),
        ];
    }
}
