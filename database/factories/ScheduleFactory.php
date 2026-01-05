<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Practice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'practice_id' => Practice::factory(),
            'exercise_id' => Exercise::factory(),
            'playerCount' => $this->faker->numberBetween(4, 20),
            'goalkeeperCount' => $this->faker->numberBetween(0, 2),
            'time' => $this->faker->randomElement(['10', '15', '20', '25', '30']),
            'coaches' => $this->faker->optional()->name(),
        ];
    }
}
