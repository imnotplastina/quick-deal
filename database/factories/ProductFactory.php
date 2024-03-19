<?php

namespace Database\Factories;

use App\Supports\AmountValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'description' => ucfirst($this->faker->words(6, true)),
            'quantity' => $this->faker->numberBetween(0, 400),
            'price' => new AmountValue(
                $this->faker->randomFloat(2, 100, 10000)
            ),
        ];
    }
}
