<?php

namespace Tests\Feature\Web;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    private function actingUser(): User
    {
        return User::factory()->create(['is_active' => true]);
    }

    public function test_guest_cannot_access_products(): void
    {
        $this->get(route('products.index'))->assertRedirect(route('login'));
    }

    public function test_index_lists_and_filters_products(): void
    {
        Product::factory()->create(['name' => 'Cheap Item', 'price' => 5, 'quantity_in_stock' => 1]);
        Product::factory()->create(['name' => 'Pricey Item', 'price' => 900, 'quantity_in_stock' => 50]);

        $response = $this->actingAs($this->actingUser())
            ->get(route('products.index', ['search' => 'Cheap']));

        $response->assertOk();
        $response->assertSee('Cheap Item');
        $response->assertDontSee('Pricey Item');
    }

    public function test_store_creates_product(): void
    {
        $response = $this->actingAs($this->actingUser())->post(route('products.store'), [
            'name' => 'New Product',
            'description' => 'desc',
            'price' => 49.90,
            'quantity_in_stock' => 7,
        ]);

        $product = Product::where('name', 'New Product')->first();

        $this->assertNotNull($product);
        $this->assertSame(7, $product->quantity_in_stock);
        $response->assertRedirect(route('products.show', $product));
    }

    public function test_store_validation_fails(): void
    {
        $response = $this->actingAs($this->actingUser())->post(route('products.store'), [
            'name' => '',
            'price' => -1,
            'quantity_in_stock' => -5,
        ]);

        $response->assertSessionHasErrors(['name', 'price', 'quantity_in_stock']);
    }

    public function test_edit_page_loads(): void
    {
        $product = Product::factory()->create();

        $this->actingAs($this->actingUser())
            ->get(route('products.edit', $product))
            ->assertOk()
            ->assertSee($product->name);
    }

    public function test_update_modifies_product(): void
    {
        $product = Product::factory()->create(['name' => 'Before']);

        $response = $this->actingAs($this->actingUser())->put(route('products.update', $product), [
            'name' => 'After',
            'description' => 'updated',
            'price' => 10,
            'quantity_in_stock' => 3,
        ]);

        $response->assertRedirect(route('products.show', $product));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'After', 'quantity_in_stock' => 3]);
    }

    public function test_destroy_deletes_product(): void
    {
        $product = Product::factory()->create();

        $this->actingAs($this->actingUser())
            ->delete(route('products.destroy', $product))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
