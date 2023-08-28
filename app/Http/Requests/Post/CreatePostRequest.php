<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required'],
			'category_id' => ['required'],
			'title' => ['required', 'string'],
			'content' => ['required', 'string'],
			'status' => ['required', 'in:Draft,Published'],
        ];
    }
}
