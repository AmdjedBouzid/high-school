<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'section_id' => 'required|exists:sections,id',
            'code' => 'required|string|max:50|unique:students',
            'record_status_id' => 'nullable|exists:record_statuses,id',
            'student_type_id' => 'nullable|exists:student_types,id',
            'section_id' => 'required|exists:sections,id',
        ];
    }
    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name is required.',
            'first_name.string' => 'The first name must be a string.',
            'first_name.max' => 'The first name may not be greater than 100 characters.',

            'last_name.required' => 'The last name is required.',
            'last_name.string' => 'The last name must be a string.',
            'last_name.max' => 'The last name may not be greater than 100 characters.',

            'section_id.required' => 'The section is required.',
            'section_id.exists' => 'The selected section is invalid.',

            'code.required' => 'The student code is required.',
            'code.string' => 'The student code must be a string.',
            'code.max' => 'The student code may not be greater than 50 characters.',
            'code.unique' => 'The student code has already been taken.',

            'record_status_id.exists' => 'The selected record status is invalid.',
            'student_type_id.exists' => 'The selected student type is invalid.',
        ];
    }
}
