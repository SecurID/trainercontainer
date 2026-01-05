<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Opponent>
 */
class OpponentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->colorName().' '.$this->faker->words(2, true),
            'notes' => $this->faker->optional()->paragraph(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
