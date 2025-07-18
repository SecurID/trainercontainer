<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'prename' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'notes' => $this->faker->sentence(),
        ];
    }
}
