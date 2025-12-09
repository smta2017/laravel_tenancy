<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->numberBetween(10, 99), // random 2-digit id
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'account_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'phone' => '+20' . fake()->unique()->numberBetween(1000000000, 1299999999), // Egyptian mobile format
        ];
    }

    /**
     * Indicate that the model's account address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'account_verified_at' => null,
        ]);
    }
}
