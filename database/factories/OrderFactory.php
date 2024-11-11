<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
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
        return [
            'user_id' => User::query()->inRandomOrder()->first()?->id ?? User::factory(),
            'order_status_id' => OrderStatus::query()->inRandomOrder()->first()?->id ?? OrderStatus::factory(),
            'payment_method_id' => PaymentMethod::query()->first()?->id ?? OrderStatus::factory()
        ];
    }
}
