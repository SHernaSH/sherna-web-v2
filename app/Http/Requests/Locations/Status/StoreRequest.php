<?php

namespace App\Http\Requests\Locations\Status;

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
            'opened' => ['required', 'boolean'],
        ];
        foreach (Language::all() as $language) {
            $rules['name-' . $language->id] = ['required', 'string', 'min:3', 'max:80'];
        }
        return $rules;
    }
}
