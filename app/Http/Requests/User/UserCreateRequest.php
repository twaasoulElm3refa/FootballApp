<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => ['required', 'string', 'min:6', 'confirmed'],

            'role' => ['required', Rule::in(['admin', 'user'])],

            'language' => ['nullable', 'string', 'max:10'],

            'timezone' => ['nullable', 'string', 'max:100'],

            'status' => [
                'nullable',
                Rule::in(['active', 'suspended', 'deleted']),
            ],
        ];
    }
}
