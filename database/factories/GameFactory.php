<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'opponent' => $this->faker->company(),
            'date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'time' => $this->faker->time('H:i'),
            'location' => $this->faker->city(),
            'notes' => $this->faker->optional()->sentence(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
