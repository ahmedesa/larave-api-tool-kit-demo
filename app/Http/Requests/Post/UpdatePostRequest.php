<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['sometimes'],
			'category_id' => ['sometimes'],
			'title' => ['sometimes', 'string'],
			'content' => ['sometimes', 'string'],
			'status' => ['sometimes', 'in:Draft,Published'],
        ];
    }
}
