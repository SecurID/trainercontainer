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
            'name' => $this->faker->words(3, true),
            'focus' => $this->faker->randomElement(['Ballbesitz', 'Abschluss', 'Passspiel', 'Dribbling', 'Kondition']),
            'material' => $this->faker->words(2, true),
            'procedure' => $this->faker->sentence(8),
            'coaching' => $this->faker->sentence(6),
            'duration' => $this->faker->numberBetween(5, 30),
            'intensity' => $this->faker->numberBetween(10, 100),
            'image' => 'https://fussballtraining24.de/wp-content/uploads/2021/04/fussballuebung-2.jpg',
            'playerCount' => $this->faker->numberBetween(4, 22),
            'goalkeeperCount' => $this->faker->numberBetween(0, 2),
            'level' => $this->faker->numberBetween(1, 5),
            'age' => $this->faker->numberBetween(6, 19),
        ];
    }
}
