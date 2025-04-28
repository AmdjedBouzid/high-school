<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSectionRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->has('name')) {
            $this->merge([
                'name' => trim(strtoupper($this->name)),
            ]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['sometimes', 'string', 'max:255'],
            'major_id' => 'sometimes|exists:majors,id',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.string' => 'The section name must be a string.',
            'name.max' => 'The section name may not be greater than 255 characters.',
            'name.unique' => 'A section with this name already exists for the selected major.',
            'major_id.exists' => 'The selected major is invalid.',
        ];
    }
}
