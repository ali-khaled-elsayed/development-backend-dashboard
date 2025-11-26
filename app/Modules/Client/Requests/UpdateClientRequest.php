<?php

namespace App\Modules\Client\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'message' => 'required|string',
            'phone' => 'required|string',
            'unitType' => 'required|string',
            'cityId' => 'required|exists:cities,id',
            'areaId' => 'required|exists:areas,id',
            'projectId' => 'required|exists:projects,id',
        ];
    }
}
