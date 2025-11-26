<?php

namespace App\Modules\PropertyTypes\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePropertyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'areaMin' => 'required|integer',
            'areaMax' => 'required|integer',
            'priceMin' => 'required|integer',
            'priceMax' => 'required|integer',
            'type' => 'required|string',
            'projectId' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'noOfBedroomsMin' => 'required|integer',
            'noOfBedroomsMax' => 'required|integer',
            'noOfBathroomsMin' => 'required|integer',
            'noOfBathroomsMax' => 'required|integer',
        ];
    }
}
