<?php

namespace App\Modules\Service\Requests;

use App\Modules\Shared\Requests\BaseGetRequestValidator;


class ListServicesRequest extends BaseGetRequestValidator
{
    public function rules(): array
    {
        $rules = [];
        return array_merge(parent::rules(), $rules);
    }
}
