<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_authenticated_user_can_create_product(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $category = Category::factory()->create();
        $response = $this->withHeaders(
            [
                'Authorization' => "Bearer {$token}",
                'Accept' => 'application/json'
            ]
        )->postJson('/api/v1/products', [
            'category_id' => $category->id,
            'name' => 'New product',
            'price' => 99.9
        ]);
        $response->assertStatus(201)->assertJsonStructure(
            [
                'success',
                'data' => ['id', 'name', 'sku']
            ]
        );
    }
}
