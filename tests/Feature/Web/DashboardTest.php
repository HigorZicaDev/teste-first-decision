<?php

namespace Tests\Feature\Web;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_dashboard(): void
    {
        $this->get(route('dashboard.index'))->assertRedirect(route('login'));
    }

    public function test_dashboard_shows_stock_metrics(): void
    {
        Product::factory()->create(['quantity_in_stock' => 100]);
        Product::factory()->create(['quantity_in_stock' => 3]);
        Product::factory()->create(['quantity_in_stock' => 0]);

        $response = $this->actingAs(User::factory()->create(['is_active' => true]))
            ->get(route('dashboard.index'));

        $response->assertOk();
        $response->assertSee('Total de produtos');
        $response->assertSee('Valor do estoque');
        $response->assertSee('Produtos com estoque baixo');
    }
}
