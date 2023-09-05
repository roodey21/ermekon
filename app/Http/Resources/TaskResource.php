<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->when($this->description, $this->description),
            'employee' => $this->employee->name,
            'package' => [
                'id' => $this->package->id,
                'name' => $this->package->name,
                'parent_id' => $this->package->parent_id,
            ],
            'start_date' => $this->when($this->start_date, $this->start_date),
            'end_date' => $this->when($this->end_date, $this->end_date),
        ];
    }
}
