<?php

namespace App\Modules\Project\Requests;

use App\Modules\Shared\Requests\BaseGetRequestValidator;


class ListProjectsRequest extends BaseGetRequestValidator
{
    public function rules(): array
    {
        $rules = [
            'city' => 'nullable|integer',
            'area' => 'nullable|integer',
            'projectType' => 'nullable|string',
            'propertyType' => 'nullable|string',
            'priceMin' => 'nullable|integer',
            'priceMax' => 'nullable|integer',
            'areaMin' => 'nullable|integer',
            'areaMax' => 'nullable|integer',
            'noOfRooms' => 'nullable|integer'
        ];
        return array_merge(parent::rules(), $rules);
    }
}
