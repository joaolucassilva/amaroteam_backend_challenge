<?php

namespace App\Http\Requests\UserRegister;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|unique:users',
            'password' => 'required|string',
            'name' => 'required|string',
        ];
    }
}
