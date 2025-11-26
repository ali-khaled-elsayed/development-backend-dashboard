<?php

namespace App\Modules\Project\Resources;

use App\Modules\Service\Resources\ServiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProjectResource extends JsonResource
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
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'description_en' => $this->description_en,
            'short_description_en' => $this->short_description_en,
            'description_ar' => $this->description_ar,
            'short_description_ar' => $this->short_description_ar,
            'metaTitle_en' => $this->meta_title_en,
            'metaTitle_ar' => $this->meta_title_ar,
            'metaDescription_en' => $this->meta_description_en,
            'metaDescription_ar' => $this->meta_description_ar,
            'ProjectArea' => $this->project_area,
            'location' => $this->location,
            'deliveryDate' => $this->delivery_date,
            'videoLink' => $this->video_link,
            'masterPlan' => $this->master_plan ? asset(Storage::url($this->master_plan)) : null,
            'logo' => $this->logo ? asset(Storage::url($this->logo)) : null,
            'type' => $this->type,
            'city' => $this->city,
            'area' => $this->area,

            'paymentPlan' => $this->payment_plan ?? [],

            'galleries' => $this->galleries->map(function ($gallery) {
                return [
                    'id' => $gallery->id,
                    'url' => asset("storage/{$gallery->url}"),
                    'type' => $gallery->type,
                ];
            }),

            'services' => ServiceResource::collection($this->services),
        ];
    }
}
