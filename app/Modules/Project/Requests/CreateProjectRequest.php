<?php

namespace App\Modules\Project\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title_en' => 'nullable|string',
            'title_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'short_description_en' => 'nullable|string',
            'short_description_ar' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'metaTitle_en' => 'nullable|string',
            'metaTitle_ar' => 'nullable|string',
            'metaDescription_en' => 'nullable|string',
            'metaDescription_ar' => 'nullable|string',
            'type' => 'nullable|string',
            'location' => 'required|string',
            'masterPlan' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'area' => 'required|integer',
            'deliveryDate' => 'nullable|date',
            'videoLink' => 'nullable|string',
            'cityId' => 'required|exists:cities,id',
            'areaId' => 'required|exists:areas,id',

            'galleries' => 'nullable|array',
            'galleries.*.file' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
            'galleries.*.type' => 'required|in:image,video',

            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',

            'paymentPlan' => 'nullable|array',
            'paymentPlan.*' => 'string|max:255',
        ];
    }
}
