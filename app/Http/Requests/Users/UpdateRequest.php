<?php

namespace App\Http\Requests\Users;

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
        return [
            'role' => ['required', 'exists:roles,id']
        ];
    }
}
