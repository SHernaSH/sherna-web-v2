<?php

namespace App\Http\Requests\Consoles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'console_type_id' => ['required', 'exists:console_types,id'],
            'location_id' => ['required', 'exists:locations,id'],
        ];
    }
}
