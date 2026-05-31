<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create(['is_active' => true]));
    }

    public function test_index_returns_paginated_envelope(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/products');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['items', 'meta' => ['current_page', 'last_page', 'per_page', 'total']],
            'message',
            'errors',
        ]);
        $this->assertSame(3, $response->json('data.meta.total'));
    }

    public function test_index_applies_filters(): void
    {
        Product::factory()->create(['name' => 'Alpha', 'price' => 10, 'quantity_in_stock' => 1]);
        Product::factory()->create(['name' => 'Beta', 'price' => 500, 'quantity_in_stock' => 99]);

        $response = $this->getJson('/api/v1/products?price_min=100');

        $response->assertOk();
        $this->assertSame(1, $response->json('data.meta.total'));
    }

    public function test_store_creates_product(): void
    {
        $response = $this->postJson('/api/v1/products', [
            'name' => 'Api Product',
            'description' => 'created via api',
            'price' => 99.90,
            'quantity_in_stock' => 10,
        ]);

        $response->assertCreated();
        $response->assertJsonPath('data.name', 'Api Product');
        $response->assertJsonPath('data.quantity_in_stock', 10);
        $this->assertDatabaseHas('products', ['name' => 'Api Product', 'quantity_in_stock' => 10]);
    }

    public function test_store_validation_returns_errors(): void
    {
        $response = $this->postJson('/api/v1/products', [
            'name' => '',
            'price' => -1,
            'quantity_in_stock' => -3,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['data', 'message', 'errors' => ['name', 'price', 'quantity_in_stock']]);
    }

    public function test_show_returns_product(): void
    {
        $product = Product::factory()->create();

        $this->getJson("/api/v1/products/{$product->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $product->id);
    }

    public function test_show_missing_product_returns_404_envelope(): void
    {
        $this->getJson('/api/v1/products/999')
            ->assertStatus(404)
            ->assertJson(['data' => null]);
    }

    public function test_update_modifies_product(): void
    {
        $product = Product::factory()->create(['name' => 'Old']);

        $response = $this->putJson("/api/v1/products/{$product->id}", [
            'name' => 'Updated',
            'price' => 20,
            'quantity_in_stock' => 5,
        ]);

        $response->assertOk();
        $response->assertJsonPath('data.name', 'Updated');
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated']);
    }

    public function test_destroy_deletes_product(): void
    {
        $product = Product::factory()->create();

        $this->deleteJson("/api/v1/products/{$product->id}")->assertOk();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
