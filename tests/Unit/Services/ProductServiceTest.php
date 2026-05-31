<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new ProductService();
    }

    public function test_create_persists_product(): void
    {
        $product = $this->service->create([
            'name' => 'Notebook',
            'description' => 'A laptop',
            'price' => 199.90,
            'quantity_in_stock' => 12,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Notebook',
            'quantity_in_stock' => 12,
        ]);
        $this->assertSame('199.90', $product->price);
    }

    public function test_update_changes_product(): void
    {
        $product = Product::factory()->create(['name' => 'Old']);

        $updated = $this->service->update($product, ['name' => 'New', 'quantity_in_stock' => 5]);

        $this->assertSame('New', $updated->name);
        $this->assertSame(5, $updated->quantity_in_stock);
    }

    public function test_delete_removes_product(): void
    {
        $product = Product::factory()->create();

        $this->service->delete($product);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
