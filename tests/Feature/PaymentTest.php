<?php

namespace Tests\Feature;

use App\Models\Order;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    public function test_user_can_view_payments_for_order()
    {
        $order = Order::factory()->hasPayments(2)->create();
        $response = $this->actingAs($this->user, 'api')->getJson("/api/orders/{$order->id}");
        $response->assertStatus(200)->assertJsonCount(2, 'data.payments');
    }

    public function test_confirmed_order_can_be_paid()
    {
        $order = Order::factory()->create(['status' => 'confirmed']);
        $response = $this->actingAs($this->user, 'api')
            ->postJson("/api/orders/{$order->id}/payments", [
                'method' => 'credit_card'
            ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'status' => 'successful',
        ]);
    }
}
