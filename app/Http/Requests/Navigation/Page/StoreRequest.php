<?php

namespace App\Http\Requests\Navigation\Page;

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
            'url' => ['required', 'string', 'alpha_dash' , 'min:3', 'max:80']
        ];
        foreach (Language::all() as $language) {
            $rules['name-' . $language->id] = ['required', 'string', 'min:3', 'max:80'];
            $rules['content-' . $language->id] = ['required_without:dropdown', 'min:50'];
        }
        return $rules;
    }
}
