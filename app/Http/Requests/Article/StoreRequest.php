<?php

namespace App\Http\Requests\Article;

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
        $rules = ['url' => ['required', 'alpha_dash' , 'min:3', 'max:80', 'unique:articles,url']];
        foreach (Language::all() as $language) {
            $rules['name-' . $language->id] = ['required', 'min:3', 'max:80'];
            $rules['description-' . $language->id] = ['required', 'min:5', 'max:255'];
            $rules['content-' . $language->id] = ['required', 'min:50'];
        }
        return $rules;
    }
}
