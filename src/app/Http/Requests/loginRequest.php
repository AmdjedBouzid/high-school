<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class loginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string|min:6',
            'deviceName' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'email or username  fields are required.',
            'login.string' => 'email or username  fields must be a valid string.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 6 characters.',

            'deviceName.required' => 'deviceName is required',
            'deviceName.string' => 'deviceName must be string'

        ];
    }
}
