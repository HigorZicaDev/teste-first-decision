<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreProductRequestTest extends TestCase
{
    use RefreshDatabase;

    private function validate(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, (new StoreProductRequest())->rules());
    }

    public function test_valid_data_passes(): void
    {
        $validator = $this->validate([
            'name' => 'Valid Product',
            'description' => 'desc',
            'price' => 10.5,
            'quantity_in_stock' => 3,
        ]);

        $this->assertTrue($validator->passes());
    }

    public function test_required_fields_fail_when_missing(): void
    {
        $validator = $this->validate([]);

        $this->assertFalse($validator->passes());
        foreach (['name', 'price', 'quantity_in_stock'] as $field) {
            $this->assertArrayHasKey($field, $validator->errors()->toArray());
        }
    }

    public function test_name_must_be_unique(): void
    {
        Product::factory()->create(['name' => 'Duplicated']);

        $validator = $this->validate([
            'name' => 'Duplicated',
            'price' => 10,
            'quantity_in_stock' => 1,
        ]);

        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    public function test_price_must_be_positive(): void
    {
        $validator = $this->validate([
            'name' => 'Cheap',
            'price' => 0,
            'quantity_in_stock' => 1,
        ]);

        $this->assertArrayHasKey('price', $validator->errors()->toArray());
    }

    public function test_quantity_cannot_be_negative(): void
    {
        $validator = $this->validate([
            'name' => 'Negative Stock',
            'price' => 10,
            'quantity_in_stock' => -1,
        ]);

        $this->assertArrayHasKey('quantity_in_stock', $validator->errors()->toArray());
    }
}
