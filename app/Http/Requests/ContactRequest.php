<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    /**
     * Získej validační pravidla pro kontaktní formulář.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'message' => ['required', 'string', 'min:50'],
            'year' => [
                'required',
                Rule::in(date('Y')),
            ],
        ];
    }
}
