<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->has('id') || $this->has('code')) {
            abort(422, 'Modification is not allowed');
        }
        return [
            'first_name' => 'sometimes|string|max:100',
            'last_name' => 'sometimes|string|max:100',
            'section_id' => 'sometimes|exists:sections,id',
            'student_state_id' => 'sometimes|exists:student_states,id',
            'student_type_id' => 'sometimes|exists:student_types,id',
            'sexe' => 'sometimes|in:M,F'
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.string' => 'The first name must be a string.',
            'first_name.max' => 'The first name may not be greater than 100 characters.',

            'last_name.string' => 'The last name must be a string.',
            'last_name.max' => 'The last name may not be greater than 100 characters.',

            'section_id.exists' => 'The selected section is invalid.',

            'code.string' => 'The student code must be a string.',
            'code.max' => 'The student code may not be greater than 50 characters.',
            'code.unique' => 'The student code has already been taken.',

            'student_state_id.exists' => 'The selected student state is invalid.',
            'student_type_id.exists' => 'The selected student type is invalid.',
        ];
    }
}
