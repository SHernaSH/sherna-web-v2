<?php

namespace App\Http\Requests\Inventory\Category;

use App\Models\Language\Language;
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
        $rules = [];
        foreach (Language::all() as $language) {
            $rules['name-' . $language->id] = ['required', 'min:3', 'max:80'];
        }
        return $rules;
    }
}
