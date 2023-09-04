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
            'client_name' => $this->customer()->first()->name,
            'packages' => $parentPackages->map(function ($package) {
                return [
                    'id' => $package->id,
                    'name' => $package->name,
                    'subpackages' => $package->subpackages->map(function ($subpackage) {
                        return [
                            'id' => $subpackage->id,
                            'name' => $subpackage->name,
                        ];
                    }),
                ];
            }),
        ];
    }
}
