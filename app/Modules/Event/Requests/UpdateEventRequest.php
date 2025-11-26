<?php

namespace App\Modules\Event\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'date' => 'nullable|date_format:Y-m-d',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',

            'galleries' => 'nullable|array',
            'galleries.*.file' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
            'galleries.*.type' => 'required|in:image,video',

            // optional deleted gallery ids
            'deleted_gallery_ids' => 'nullable|array',
            'deleted_gallery_ids.*' => 'exists:gallerys,id',

        ];
    }
}
