<?php

namespace Feature;

use App\Enums\OrderStatus;
use App\Models\Order;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_user_can_create_order_with_products()
    {
        $payload = [
            'products' => [
                [
                    'name' => 'Laptop',
                    'quantity' => 1,
                    'price' => 1500,
                ],
                [
                    'name' => 'Mouse',
                    'quantity' => 2,
                    'price' => 50,
                ],
            ],
        ];
        $response = $this->actingAs($this->user, 'api')->postJson('/api/orders', $payload);
        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'status' => OrderStatus::PENDING->value,
            'total_amount' => 1600,
        ]);
    }

    public function test_create_order_fails_without_products()
    {
        $response = $this->actingAs($this->user, 'api')->postJson('/api/orders', []);
        $response->assertStatus(422)->assertJsonValidationErrors(['products']);
    }

    public function test_pending_order_can_be_updated()
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::PENDING,
        ]);
        $payload = [
            'products' => [
                [
                    'name' => 'Keyboard',
                    'quantity' => 1,
                    'price' => 200,
                ],
            ],
            'status' => OrderStatus::CONFIRMED,
        ];
        $response = $this->actingAs($this->user, 'api')->putJson("/api/orders/{$order->id}", $payload);
        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'total_amount' => 200,
        ]);
    }

    public function test_confirmed_order_cannot_be_updated()
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::CONFIRMED,
        ]);
        $payload = [
            'products' => [
                [
                    'name' => 'Monitor',
                    'quantity' => 1,
                    'price' => 400,
                ],
            ],
            'status' => OrderStatus::CANCELLED,
        ];
        $response = $this->actingAs($this->user, 'api')->putJson("/api/orders/{$order->id}", $payload);
        $response->assertStatus(422);
    }

    public function test_order_without_payments_can_be_deleted()
    {
        $order = Order::factory()->create();
        $response = $this->actingAs($this->user, 'api')->deleteJson("/api/orders/{$order->id}");
        $response->assertStatus(204);
        $order->refresh();
        $this->assertEquals(OrderStatus::CANCELLED->value, $order->status->value);
    }

    public function test_order_with_payments_cannot_be_deleted()
    {
        $order = Order::factory()->hasPayments(1)->create();
        $response = $this->actingAs($this->user, 'api')->deleteJson("/api/orders/{$order->id}");
        $response->assertStatus(422);
    }

    public function test_user_can_view_his_order()
    {
        $order = Order::factory()->hasProducts(2)->create();
        $response = $this->actingAs($this->user, 'api')->getJson("/api/orders/{$order->id}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'order_number',
                    'status',
                    'total_amount',
                    'products',
                ],
            ]);
    }
}
