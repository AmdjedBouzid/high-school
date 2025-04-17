<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;


class SupervisorUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        
        if ($this->has('id')) {
            abort(422, 'ID modification is not allowed');
        }
        if ($this->has('code')) {
            abort(422, 'Code modification is not allowed');
        }
        
        foreach ($this->all() as $field => $value) {
            switch ($field) {
                case 'first_name':
                case 'last_name':
                    $rules[$field] = 'string|max:100';
                    break;
                case 'class':
                    $rules[$field] = "sometimes|string|max:50";
                    break;
                case 'student_state_id':
                    $rules[$field] = 'nullable|exists:student_states,id';
                    break;
                case 'student_state_id':
                    $rules[$field] = 'nullable|exists:student_types,id';
                    break;
            }
        }
        return $rules;
    }
}
