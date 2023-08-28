<?php

namespace App\Http\Requests\Post;

use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['sometimes'],
			'category_id' => ['sometimes'],
			'title' => ['sometimes', 'string'],
			'content' => ['sometimes', 'string'],
            'status' => ['sometimes', Rule::in(PostStatus::getAll())],
        ];
    }
}
