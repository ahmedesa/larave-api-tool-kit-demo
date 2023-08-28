<?php

namespace App\Http\Requests\Post;

use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required'],
			'category_id' => ['required'],
			'title' => ['required', 'string'],
			'content' => ['required', 'string'],
			'status' => ['required', Rule::in(PostStatus::getAll())],
        ];
    }
}
