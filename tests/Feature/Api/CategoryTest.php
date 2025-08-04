<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Language;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    protected function createLanguages()
    {
        Language::factory()->create(['code' => 'en', 'name' => 'English']);
        Language::factory()->create(['code' => 'fr', 'name' => 'French']);
    }

    public function test_index_returns_categories()
    {
        $this->authenticate();
        $this->createLanguages();
        Category::factory()->count(3)->create();
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_store_creates_category_with_localization()
    {
        $this->authenticate();
        $this->createLanguages();

        $payload = [
            'key' => 'test-category',
            'tag' => 'web',
            'name' => ['en' => 'English Name'],
            'description' => ['en' => 'English Description']
        ];

        $response = $this->postJson('/api/categories', $payload);
        $response->assertStatus(201)
                 ->assertJsonFragment(['key' => 'test-category']);
    }

    public function test_update_category()
    {
        $this->authenticate();
        $this->createLanguages();

        $category = Category::factory()->create([
            'key' => 'test-category',
            'tag' => 'web',
            'name' => ['en' => 'Old Name'],
            'description' => ['en' => 'Old Desc']
        ]);

        $payload = [
            'name' => ['en' => 'Updated Name'],
            'description' => ['en' => 'Updated Desc'],
            'tag' => 'mobile'
        ];

        $response = $this->putJson("/api/categories/{$category->id}", $payload);
        $response->assertStatus(200)
                 ->assertJsonFragment(['tag' => 'mobile']);
    }
}
