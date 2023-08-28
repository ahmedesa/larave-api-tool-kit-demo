<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => createOrRandomFactory(\App\Models\User::class),
			'category_id' => createOrRandomFactory(\App\Models\Category::class),
			'title' => $this->faker->firstName(),
			'content' => $this->faker->text(),
			'status' => $this->faker->randomElement(\App\Enums\PostStatus::getAll()),
        ];
    }
}
