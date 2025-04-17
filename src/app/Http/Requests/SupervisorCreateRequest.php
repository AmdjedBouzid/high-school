<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;



class SupervisorCreateRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'username' => [
                'required',
                'string',
                'max:30',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('users')
            ],
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

            'phone_number' => 'nullable|string|max:10|regex:/^0\d{9}$/',
            'address' => 'nullable|string|max:255',
            'sexe' => 'required|in:M,F'
        ];
    }
}
