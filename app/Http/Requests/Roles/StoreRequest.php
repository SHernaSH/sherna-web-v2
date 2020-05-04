<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string' , 'min:3', 'max:80'],
            'description' => ['required', 'string' , 'min:5', 'max:255'],
            'permissions.*' => ['exists:permissions,id'],
        ];
    }
}
