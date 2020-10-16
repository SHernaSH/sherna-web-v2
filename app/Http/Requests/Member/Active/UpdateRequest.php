<?php

namespace App\Http\Requests\Member\Active;

use App\Models\Language\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class UpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'sub_name' => ['required', 'string', 'alpha_dash' , 'min:3', 'max:80'],
            'sub_nickname' => ['required', 'string', 'alpha_dash' , 'min:3', 'max:80'],
            'sub_email' => ['required', 'email', ],
            'sub_room' => ['required', 'string' , 'min:3', 'max:80'],
            'file' => ['nullable', 'image']
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($validator->invalid()) > 0) {
                Session::reflash();
            }
        });
    }
}
