<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMajorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $majorId = $this->route('major')->id ?? null;

        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('majors')
                    ->where(fn($query) => $query->where('grade_id', $this->grade_id))
                    ->ignore($majorId),
            ],
            'grade_id' => [
                'sometimes',
                'exists:grades,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'The major name must be a string.',
            'name.max' => 'The major name may not be greater than 255 characters.',
            'name.unique' => 'A major with this name already exists for the selected grade.',
            'grade_id.exists' => 'The selected grade does not exist.',
        ];
    }
}
