<?php

namespace App\Modules\Career\Requests;

use App\Modules\Shared\Requests\BaseGetRequestValidator;


class ListCareersRequest extends BaseGetRequestValidator
{
    public function rules(): array
    {
        $rules = [
            'title' => 'nullable|string',
        ];
        return array_merge(parent::rules(), $rules);
    }
}
