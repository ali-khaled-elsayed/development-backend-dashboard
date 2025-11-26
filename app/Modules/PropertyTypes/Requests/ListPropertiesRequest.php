<?php

namespace App\Modules\PropertyTypes\Requests;

use App\Modules\Shared\Requests\BaseGetRequestValidator;


class ListPropertiesRequest extends BaseGetRequestValidator
{
    public function rules(): array
    {
        $rules = [
            'projectId' => 'nullable|integer',
        ];
        return array_merge(parent::rules(), $rules);
    }
}
