<?php

namespace App\Modules\Event\Requests;

use App\Modules\Shared\Requests\BaseGetRequestValidator;


class ListEventsRequest extends BaseGetRequestValidator
{
    public function rules(): array
    {
        $rules = [
            'title' => 'nullable|string',
        ];
        return array_merge(parent::rules(), $rules);
    }
}
