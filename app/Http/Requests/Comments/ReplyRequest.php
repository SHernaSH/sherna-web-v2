<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment_body' => ['required', 'min:3', 'max:255'],
            'comment_id'   => ['required', 'exists:comments,id'],
            'article_id'   => ['required', 'exists:articles,id'],
        ];
    }
}
