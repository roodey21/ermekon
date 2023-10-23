<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'package' => [
                'id' => $this->package->id,
                'name' => $this->package->name,
                'parent_id' => $this->package->parent_id,
            ],
            'start_date' => $this->when($this->start_date, Carbon::parse($this->start_date)->format('Y-m-d')),
            'end_date' => $this->when($this->end_date, Carbon::parse($this->end_date)->format('Y-m-d')),
            'products' => $this->products
                ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'volume' => $product->pivot->volume,
                    'unit' => $product->main_unit->name,
                    'transaction_type' => $product->pivot->transaction_type,
                    'price' => $product->pivot->price,
                ];
            }),
            'documents' => $this->documents->map(function ($document) {
                return [
                    'id' => $document->uuid,
                    'name' => $document->file_name,
                    'url' => $document->getUrl(),
                ];
            }),
        ];
    }
}
