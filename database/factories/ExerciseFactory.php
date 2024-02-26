<?php

namespace Database\Factories;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ExerciseFactory extends Factory
{
    protected $model = Exercise::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'focus' => $this->faker->word(),
            'material' => $this->faker->word(),
            'procedure' => $this->faker->word(),
            'coaching' => $this->faker->word(),
            'duration' => $this->faker->randomNumber(),
            'intensity' => $this->faker->word(),
            'image' => $this->faker->word(),
            'playerCount' => $this->faker->randomNumber(),
            'goalkeeperCount' => $this->faker->randomNumber(),
            'level' => $this->faker->randomNumber(),
            'age' => $this->faker->randomNumber(),
            'user_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
