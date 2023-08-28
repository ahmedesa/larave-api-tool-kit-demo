<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use  RefreshDatabase;

    protected string $endpoint = '/api/posts';
    protected string $tableName = 'posts';

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreatePost(): void
    {
        $this->actingAs(User::factory()->create());

        $payload = Post::factory()->make([])->toArray();

        $this->json('POST', $this->endpoint, $payload)
            ->assertStatus(201)
            ->assertSee($payload['title']);

        $this->assertDatabaseHas($this->tableName, ['id' => 1]);
    }

    public function testViewAllPostsSuccessfully(): void
    {
        $this->actingAs(User::factory()->create());

        Post::factory(5)->create();

        $this->json('GET', $this->endpoint)
             ->assertStatus(200)
             ->assertJsonCount(5, 'data')
             ->assertSee(Post::first(rand(1, 5))->title);
    }

    public function testViewAllPostsByFooFilter(): void
    {
        $this->actingAs(User::factory()->create());

        Post::factory(5)->create([
            'category_id' => $category1 = Category::factory()->create()
        ]);

        Post::factory(7)->create([
            'category_id' => $category2 = Category::factory()->create()
        ]);

        $this->json('GET', $this->endpoint . '?category_id=' . $category2->id)
            ->assertStatus(200)
            ->assertJsonCount(7, 'data');

    }

    public function testsCreatePostValidation(): void
    {
        $this->actingAs(User::factory()->create());

        $data = [
        ];

        $this->json('post', $this->endpoint, $data)
             ->assertStatus(422);
    }

    public function testViewPostData(): void
    {
        $this->actingAs(User::factory()->create());

        Post::factory()->create();

        $this->json('GET', $this->endpoint.'/1')
             ->assertSee(Post::first()->name)
             ->assertStatus(200);
    }

    public function testUpdatePost(): void
    {
        $this->actingAs(User::factory()->create());

        Post::factory()->create();

        $payload = [
            'title' => 'Random'
        ];

        $this->json('PUT', $this->endpoint.'/1', $payload)
             ->assertStatus(200)
             ->assertSee($payload['title']);
    }

    public function testDeletePost(): void
    {
        $this->actingAs(User::factory()->create());

        Post::factory()->create();

        $this->json('DELETE', $this->endpoint.'/1')
             ->assertStatus(204);

        $this->assertEquals(0, Post::count());
    }

}
