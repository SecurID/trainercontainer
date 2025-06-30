<?php

namespace Database\Factories;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    protected $model = Rating::class;

    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeThisMonth()->format('Y-m-d'),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}

