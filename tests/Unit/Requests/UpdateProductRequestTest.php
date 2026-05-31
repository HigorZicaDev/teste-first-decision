<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateProductRequestTest extends TestCase
{
    use RefreshDatabase;

    private function rulesFor(Product $product): array
    {
        $request = new UpdateProductRequest();

        $route = new Route(['PUT'], 'products/{product}', []);
        $route->bind(Request::create('/products/'.$product->id, 'PUT'));
        $route->setParameter('product', $product);

        $request->setRouteResolver(fn () => $route);

        return $request->rules();
    }

    public function test_same_name_is_allowed_for_current_product(): void
    {
        $product = Product::factory()->create(['name' => 'Keep Name']);

        $validator = Validator::make([
            'name' => 'Keep Name',
            'price' => 10,
            'quantity_in_stock' => 1,
        ], $this->rulesFor($product));

        $this->assertTrue($validator->passes());
    }

    public function test_name_used_by_another_product_fails(): void
    {
        Product::factory()->create(['name' => 'Taken']);
        $product = Product::factory()->create(['name' => 'Mine']);

        $validator = Validator::make([
            'name' => 'Taken',
            'price' => 10,
            'quantity_in_stock' => 1,
        ], $this->rulesFor($product));

        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }
}
