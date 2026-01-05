<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Warmup', 'Passing', 'Shooting', 'Dribbling', 'Defending', 'Tactics', 'Conditioning', 'Goalkeeping', 'Set Pieces', 'Cool Down'];

        return [
            'name' => $this->faker->unique()->randomElement($categories).' '.$this->faker->word(),
        ];
    }
}
