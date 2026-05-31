<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes(): void
    {
        $product = new Product();

        $this->assertSame(
            ['name', 'description', 'price', 'quantity_in_stock'],
            $product->getFillable()
        );
    }

    public function test_price_is_cast_with_two_decimals(): void
    {
        $product = Product::factory()->create(['price' => 10]);

        $this->assertSame('10.00', $product->price);
    }

    public function test_stock_status_thresholds(): void
    {
        $cases = [
            [0, 'red'],
            [9, 'red'],
            [10, 'yellow'],
            [15, 'yellow'],
            [16, 'green'],
            [100, 'green'],
        ];

        foreach ($cases as [$quantity, $expected]) {
            $product = Product::factory()->make(['quantity_in_stock' => $quantity]);
            $this->assertSame($expected, $product->stock_status, "quantity {$quantity}");
        }
    }

    public function test_filter_scope_by_search_and_ranges(): void
    {
        Product::factory()->create(['name' => 'Alpha Widget', 'price' => 5, 'quantity_in_stock' => 2]);
        Product::factory()->create(['name' => 'Beta Gadget', 'price' => 50, 'quantity_in_stock' => 100]);
        Product::factory()->create(['name' => 'Gamma Widget', 'price' => 500, 'quantity_in_stock' => 5]);

        $bySearch = Product::query()->filter(['search' => 'Widget'])->get();
        $this->assertCount(2, $bySearch);

        $byPrice = Product::query()->filter(['price_min' => 10, 'price_max' => 100])->get();
        $this->assertCount(1, $byPrice);
        $this->assertSame('Beta Gadget', $byPrice->first()->name);

        $byStock = Product::query()->filter(['stock_min' => 10])->get();
        $this->assertCount(1, $byStock);
        $this->assertSame('Beta Gadget', $byStock->first()->name);
    }
}
