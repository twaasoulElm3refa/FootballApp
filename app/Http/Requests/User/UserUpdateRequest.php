<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            'username' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($userId),
            ],

            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'password' => ['nullable', 'string', 'min:6', 'confirmed'],

            'role' => ['sometimes', 'required', Rule::in(['admin', 'user'])],

            'language' => ['sometimes', 'required', 'string', 'max:10'],

            'timezone' => ['sometimes', 'required', 'string', 'max:100'],

            'status' => [
                'sometimes',
                'required',
                Rule::in(['active', 'suspended', 'deleted']),
            ],
        ];
    }
}
