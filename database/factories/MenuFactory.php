<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'restaurant_id' => 1,
            'name' => fake()->name(),
            'description' => fake()->text(),
            'image' => null,
            'price' => fake()->numberBetween(1, 100),
            'discount' => fake()->numberBetween(1, 100),
            'available' => true,
        ];
    }
}
