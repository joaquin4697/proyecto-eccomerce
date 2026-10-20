<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(OrderStatus::cases())->value,
            'total' => 0, // se recalcula después de agregar items
        ];
    }
}