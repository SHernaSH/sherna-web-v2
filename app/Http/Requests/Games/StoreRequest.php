<?php

namespace App\Http\Requests\Games;

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
        return [
            'name' => ['required', 'string', 'max:255'],
            'possible_players' => ['required', 'integer', 'min:1'],
            'console_id' => ['required', 'exists:consoles,id'],
            'serial_id' => ['required'],
            'inventory_id' => ['required'],
        ];
    }
}
