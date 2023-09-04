<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tasks = $this->tasks()->get();

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'subpackages' => PackageResource::collection($this->subpackages),
            'tasks' => $tasks->count() > 0 ? TaskResource::collection($tasks) : null,

        ];
        return $data;
    }
}
