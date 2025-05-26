<?php

namespace App\Http\Requests\employees;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name'  => 'sometimes|required|string|max:255',
            'username'   => 'sometimes|required|string|unique:users,username,' . $id,
            'email'      => 'sometimes|required|email|unique:users,email,' . $id,
            'password'   => 'nullable|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'username.required'   => 'Username is required.',
            'username.unique'     => 'This username is already taken.',
            'email.required'      => 'Email is required.',
            'email.unique'        => 'This email is already registered.',
            'email.email'         => 'Please enter a valid email address.',
            'password.required'   => 'Password is required.',
            'password.min'        => 'Password must be at least 6 characters.',
        ];
    }
}
