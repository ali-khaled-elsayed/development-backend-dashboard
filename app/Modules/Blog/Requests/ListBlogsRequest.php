<?php

namespace App\Modules\Blog\Requests;

use App\Modules\Shared\Requests\BaseGetRequestValidator;


class ListBlogsRequest extends BaseGetRequestValidator
{
    public function rules(): array
    {
        $rules = [
            'title' => 'nullable|string',
        ];
        return array_merge(parent::rules(), $rules);
    }
}
