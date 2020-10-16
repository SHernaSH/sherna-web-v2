<?php

namespace App\Http\Requests\Navigation\Page;

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
        $rules = [];
        foreach (Language::all() as $language) {
            $rules['name-' . $language->id] = ['required', 'string', 'min:3', 'max:80'];
            $rules['content-' . $language->id] = ['required_without:dropdown', 'nullable', 'min:50'];
        }
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
