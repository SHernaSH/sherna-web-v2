<?php

namespace App\Http\Requests\Settings;

use App\Models\Settings\Setting;
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
        foreach (Setting::all() as $setting) {
            $rules['value-' . $setting->id] = ['required', 'numeric', 'min:0'];
        }
        return $rules;
    }
}
