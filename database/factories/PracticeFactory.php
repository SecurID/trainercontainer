<?php

namespace Database\Factories;

use App\Models\Practice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PracticeFactory extends Factory
{
    protected $model = Practice::class;

    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 year', '+1 month')->format('Y-m-d'),
            'time' => $this->faker->time('H:i'),
            'topic' => $this->faker->randomElement([
                '1 on 1', 'Passspiel', 'Abschluss', 'Dribbling', 'Kondition', 'Taktik', 'Spielformen', 'Technik', 'Koordination'
            ]),
        ];
    }
}

