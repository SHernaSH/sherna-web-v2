<?php

namespace App\Http\Requests\Inventory;

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
        $rules = [
            'category_id' => ['required', 'exists:inventory_categories,id'],
            'serial_id' => 'required',
            'inventory_id' => 'required',
            'location_id' => ['required', 'exists:locations,id'],
        ];
        foreach (Language::all() as $language) {
            $rules['name-' . $language->id] = ['required', 'string', 'min:3', 'max:80'];
        }
        return $rules;
    }
}
