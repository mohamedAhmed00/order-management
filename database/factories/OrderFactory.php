<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::first();
        return [
            'user_id' => $user->id,
            'total_amount' => 10000,
            'order_number' => 'ORD-123456789' . time(),
            'status' => 'pending',
        ];
    }
}
