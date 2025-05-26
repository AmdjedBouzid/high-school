<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;

class SectionRequest extends FormRequest
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
    protected function prepareForValidation(): void
    {
        if ($this->has('name')) {
            $this->merge([
                'name' => trim(strtoupper($this->name)),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sections')->where(function ($query) {
                    return $query->where('major_id', $this->major_id);
                }),
            ],
            'major_id' => 'required|exists:majors,id',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'The section name is required.',
            'name.string' => 'The section name must be a string.',
            'name.max' => 'The section name may not be greater than 255 characters.',
            'name.unique' => 'A section with this name already exists for the selected major.',
            'major_id.required' => 'The major is required.',
            'major_id.exists' => 'The selected major is invalid.',
        ];
    }
}
