<?php

namespace App\Modules\User\Requests;

use Illuminate\Validation\Rules\Enum;
use App\Modules\User\Enums\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'userId' => 'required|integer|min:1|exists:users,id',
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,$this->userId",
            'phone' => "required|string|unique:users,phone,$this->userId",
            'image' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
            'role' => ['nullable', new Enum(UserTypeEnum::class)],
            'isActive'=> 'nullable|boolean',
        ];
    }

    public function  prepareForValidation()
    {
        $this->merge([
            'userId' => (int) $this->route('userId'),
        ]);
    }
}
