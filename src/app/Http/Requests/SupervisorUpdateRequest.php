<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;
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
        if ($this->has('role_id') && Gate::denies('admin-level')) {
            abort(403, 'You are not authorized to change the role');
        }
        
        foreach ($this->all() as $field => $value) {
            switch ($field) {
                case 'username':
                    $rules[$field] = [
                        'string',
                        'max:30',
                        Rule::unique('users'),
                    ];
                    break;
                case 'email':
                    $rules[$field] = [
                        'email',
                        'max:255',
                        Rule::unique('users'),
                    ];
                    break;
                case 'password':
                    $rules[$field] = ['string', 'min:8'];
                    break;
                case 'first_name':
                case 'last_name':
                    $rules[$field] = 'string|max:100';
                    break;
                case 'role_id':
                    $rules[$field] = 'nullable|exists:roles,id';
                    break;
                case 'supervisor_info':
                    $rules['supervisor_info.phone_number'] = 'sometimes|string|max:20';
                    $rules['supervisor_info.address'] = 'sometimes|string|max:255';
                    $rules['supervisor_info.sexe'] = 'sometimes|in:M,F';
                    break;
            }
        }
        return $rules;
    }
}
