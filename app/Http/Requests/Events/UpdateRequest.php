<?php

namespace App\Http\Requests\Events;

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
            'points' => ['required', 'integer', 'min:1'],
            'from_date' => ['required', 'date', 'after:now'],
            'to_date' => ['required', 'date', 'after:from_date'],
            'location_id' => ['required', 'exists:locations,id'],
        ];
    }
}
