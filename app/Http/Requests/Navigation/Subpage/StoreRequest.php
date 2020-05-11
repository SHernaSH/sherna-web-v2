<?php

namespace App\Http\Requests\Navigation\Subpage;

use App\Models\Language\Language;
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
        $rules = [
            'sub_url' => ['required', 'string', 'alpha_dash' , 'min:3', 'max:80']
        ];
        foreach (Language::all() as $language) {
            $rules['sub_name-' . $language->id] = ['required', 'string', 'min:3', 'max:80'];
            $rules['sub_text_content-' . $language->id] = ['required', 'min:50'];
        }
        return $rules;
    }
}
