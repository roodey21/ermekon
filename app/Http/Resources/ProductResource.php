<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'main_unit' => $this->main_unit,
            'conversion' => $this->conversion_units->map(function ($conversion) {
                return [
                    'unit_id' => $conversion->id,
                    'name' => $conversion->name,
                    'value' => $conversion->pivot->conversion_factor,
                ];
            }),
            'type' => $this->type,
            'variants' => $this->productVariants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'name' => $variant->variant->name,
                    'values' => json_decode($variant->values),
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
