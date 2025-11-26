<?php

namespace App\Modules\PropertyTypes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PropertyResource extends JsonResource
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
            'areaMin' => $this->area_min,
            'areaMax' => $this->area_max,
            'priceMin' => $this->price_min,
            'priceMax' => $this->price_max,
            'type' => $this->type,
            'projectId' => $this->project_id,
            'image' => $this->image ? asset(Storage::url($this->image)) : null,
            'noOfBedroomsMin' => $this->no_of_bedrooms_min,
            'noOfBedroomsMax' => $this->no_of_bedrooms_max,
            'noOfBathroomsMin' => $this->no_of_bathrooms_min,
            'noOfBathroomsMax' => $this->no_of_bathrooms_max,
        ];
    }
}
