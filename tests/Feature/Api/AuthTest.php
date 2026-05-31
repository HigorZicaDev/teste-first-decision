<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private function user(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'password' => Hash::make('password123'),
            'is_active' => true,
        ], $attributes));
    }

    public function test_register_returns_token(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Api User',
            'email' => 'apiuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure(['data' => ['token', 'token_type'], 'message', 'errors']);
        $this->assertDatabaseHas('users', ['email' => 'apiuser@example.com']);
    }

    public function test_register_validation_returns_envelope(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['data', 'message', 'errors' => ['name', 'email', 'password']]);
    }

    public function test_login_returns_token(): void
    {
        $user = $this->user();

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['data' => ['token', 'token_type'], 'message', 'errors']);
        $this->assertNull($response->json('errors'));
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $user = $this->user();

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'wrong',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['data' => null]);
    }

    public function test_login_validation_returns_envelope(): void
    {
        $response = $this->postJson('/api/v1/login', []);

        $response->assertStatus(422);
        $response->assertJsonStructure(['data', 'message', 'errors' => ['email', 'password']]);
    }

    public function test_protected_route_requires_token(): void
    {
        $this->getJson('/api/v1/products')
            ->assertStatus(401)
            ->assertJson(['data' => null]);
    }

    public function test_logout_revokes_token(): void
    {
        Sanctum::actingAs($this->user());

        $this->postJson('/api/v1/logout')->assertOk();
    }
}
