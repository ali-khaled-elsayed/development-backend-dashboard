<?php

namespace App\Modules\User\Requests;

use App\Modules\User\Enums\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
            'role' =>  ['nullable', new Enum(UserTypeEnum::class)],
            'isActive'=> 'nullable|boolean',
        ];
    }
}
