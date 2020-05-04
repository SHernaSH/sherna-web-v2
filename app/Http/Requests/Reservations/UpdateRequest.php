<?php

namespace App\Http\Requests\Reservations;

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
            'location_id' => ['required', 'exists:locations,id'],
            'visitors_count' => ['required', 'integer' ,'min:1'],
            'from_date' => ['required', 'date'],
            'to_date' => ['required'],
        ];
    }
}
