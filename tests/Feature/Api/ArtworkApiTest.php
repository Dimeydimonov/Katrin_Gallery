<?php

namespace Tests\Feature\Api;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// тесты api
class ArtworkApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_index_returns_artworks(): void
    {
        $category = Category::factory()->create();
        Artwork::factory()->count(3)->create([
            'category_id'  => $category->id,
            'is_available' => true,
        ]);

        $response = $this->getJson('/api/public/artworks');

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'data']);
    }

    public function test_public_show_returns_single_artwork(): void
    {
        $category = Category::factory()->create();
        $artwork  = Artwork::factory()->create(['category_id' => $category->id]);

        $response = $this->getJson("/api/public/artworks/{$artwork->slug}");

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'success']);
    }

    public function test_store_requires_authentication(): void
    {
        $response = $this->postJson('/api/artworks', []);

        $response->assertStatus(401);
    }

    public function test_search_returns_matching_artworks(): void
    {
        $category = Category::factory()->create();
        Artwork::factory()->create([
            'title'        => 'Beautiful Sunset',
            'category_id'  => $category->id,
            'is_available' => true,
        ]);

        $response = $this->getJson('/api/public/artworks/search?query=Sunset');

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'success']);
    }
}
