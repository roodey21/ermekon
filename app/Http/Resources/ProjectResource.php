<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parentPackages = $this->packages()->whereNull('parent_id')->get();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'client_name' => $this->customer()->count() > 0 ? $this->customer()->first()->name:null,
            'start_date' => $this->start_date ? $this->start_date->format('d-m-Y'):null,
            'end_date' => $this->end_date ? $this->end_date->format('d-m-Y'):null,
            'status' => $this->status ?: null,
            'created_at' => $this->created_at->format('d-m-Y'),
            'description' => $this->description,
            'packages' => $parentPackages->map(function ($package) {
                return [
                    'id' => $package->id,
                    'name' => $package->name,
                    'description' => $package->description,
                    'project_id' => $package->project_id,
                    'subpackages' => $package->subpackages->map(function ($subpackage) {
                        return [
                            'id' => $subpackage->id,
                            'name' => $subpackage->name,
                            'tasks' => $subpackage->tasks->map(function ($task) {
                                return [
                                    'id' => $task->id,
                                    'name' => $task->name,
                                    'package_id' => $task->package_id,
                                    'package_name' => $task->package->name,
                                ];
                            }),
                        ];
                    }),
                ];
            }),
            'tasks' => $this->tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'name' => $task->name,
                    'package_id' => $task->package_id,
                    'package_name' => $task->package->name,
                ];
            }),
            'task_count' => $this->tasks->count(),
        ];
    }
}
