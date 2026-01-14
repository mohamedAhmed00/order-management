<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => 1,
            'method' => 'credit_card',
            'status' => 'pending',
            'amount' => 10000,
            'transaction_reference' => '1234567890',
            'response' => [],

        ];
    }
}
