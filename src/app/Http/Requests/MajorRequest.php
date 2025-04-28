<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MajorRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('majors')->where(function ($query) {
                    return $query->where('grade_id', $this->grade_id);
                }),
            ],
            'grade_id' => ['required', 'exists:grades,id'],
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'The major name is required.',
            'name.string' => 'The major name must be a string.',
            'name.max' => 'The major name may not be greater than 255 characters.',
            'name.unique' => 'This major name already exists.',

            'grade_id.required' => 'The grade is required.',
            'grade_id.exists' => 'The selected grade is invalid.',
        ];
    }
}
