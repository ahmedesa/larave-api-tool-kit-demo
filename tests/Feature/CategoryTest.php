<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use  RefreshDatabase;

    protected string $endpoint = '/api/categories';
    protected string $tableName = 'categories';

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function testCreateCategory(): void
    {
        $this->actingAs(User::factory()->create());

        $payload = Category::factory()->make([])->toArray();
        $payload['image'] = UploadedFile::fake()->image('image.jpg');

        $this->json('POST', $this->endpoint, $payload)
             ->assertStatus(201)
             ->assertSee($payload['name']);

        $this->assertDatabaseHas($this->tableName, ['id' => 1]);
    }

    public function testViewAllCategoriesSuccessfully(): void
    {
        $this->actingAs(User::factory()->create());

        Category::factory(5)->create();

        $this->json('GET', $this->endpoint)
             ->assertStatus(200)
             ->assertJsonCount(5, 'data')
             ->assertSee(Category::first(rand(1, 5))->name);
    }

    public function testViewAllCategoriesByNameSearch(): void
    {
        $this->actingAs(User::factory()->create());

        Category::factory(1)->create([
            'name' => 'aa'
        ]);

        Category::factory(1)->create([
            'name' => 'bb'
        ]);

        $this->json('GET', $this->endpoint.'?search=aa')
             ->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertSee('aa')
            ->assertDontSee('bb');
    }

    public function testsCreateCategoryValidation(): void
    {
        $this->actingAs(User::factory()->create());

        $data = [
        ];

        $this->json('post', $this->endpoint, $data)
             ->assertStatus(422);
    }

    public function testViewCategoryData(): void
    {
        $this->actingAs(User::factory()->create());

        Category::factory()->create();

        $this->json('GET', $this->endpoint.'/1')
             ->assertSee(Category::first()->name)
             ->assertStatus(200);
    }

    public function testUpdateCategory(): void
    {
        $this->actingAs(User::factory()->create());

        Category::factory()->create();

        $payload = [
            'name' => 'Random'
        ];

        $this->json('PUT', $this->endpoint.'/1', $payload)
             ->assertStatus(200)
             ->assertSee($payload['name']);
    }

    public function testDeleteCategory(): void
    {
        $this->actingAs(User::factory()->create());

        Category::factory()->create();

        $this->json('DELETE', $this->endpoint.'/1')
             ->assertStatus(204);

        $this->assertEquals(0, Category::count());
    }

}
