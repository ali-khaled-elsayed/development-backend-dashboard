<?php

namespace App\Modules\Client\Requests;

use App\Modules\Shared\Requests\BaseGetRequestValidator;


class ListClientsRequest extends BaseGetRequestValidator
{
    public function rules(): array
    {
        $rules = [
            'unitType' => 'nullable|string',
        ];
        return array_merge(parent::rules(), $rules);
    }
}
