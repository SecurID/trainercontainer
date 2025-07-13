<?php

namespace Database\Factories;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
            'image' => $this->generateFakeImage(),
            'playerCount' => $this->faker->numberBetween(4, 22),
            'goalkeeperCount' => $this->faker->numberBetween(0, 2),
            'level' => $this->faker->numberBetween(1, 5),
            'age' => $this->faker->numberBetween(6, 19),
        ];
    }

    /**
     * Generate a fake image file and store it in the exercises directory
     */
    private function generateFakeImage(): string
    {
        // Generate filename
        $filename = 'exercise_' . uniqid() . '.svg';
        $filepath = 'exercises/' . $filename;

        // Ensure the exercises directory exists in public storage
        Storage::disk('public')->makeDirectory('exercises');

        // Create a simple SVG image
        $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#98D8C8'];
        $bgColor = $this->faker->randomElement($colors);
        $textColor = '#2C3E50';

        $svg = '<?xml version="1.0" encoding="UTF-8"?>
<svg width="800" height="600" xmlns="http://www.w3.org/2000/svg">
  <rect width="100%" height="100%" fill="' . $bgColor . '"/>

  <!-- Soccer field representation -->
  <rect x="100" y="100" width="600" height="400" fill="none" stroke="white" stroke-width="3"/>
  <circle cx="400" cy="300" r="80" fill="none" stroke="white" stroke-width="3"/>
  <line x1="400" y1="100" x2="400" y2="500" stroke="white" stroke-width="3"/>

  <!-- Goal areas -->
  <rect x="100" y="220" width="60" height="160" fill="none" stroke="white" stroke-width="2"/>
  <rect x="640" y="220" width="60" height="160" fill="none" stroke="white" stroke-width="2"/>

  <!-- Title -->
  <text x="400" y="50" font-family="Arial, sans-serif" font-size="24" fill="' . $textColor . '" text-anchor="middle" font-weight="bold">Exercise Diagram</text>

  <!-- Player positions (example) -->
  <circle cx="200" cy="300" r="15" fill="' . $textColor . '"/>
  <circle cx="300" cy="250" r="15" fill="' . $textColor . '"/>
  <circle cx="300" cy="350" r="15" fill="' . $textColor . '"/>
  <circle cx="500" cy="250" r="15" fill="' . $textColor . '"/>
  <circle cx="500" cy="350" r="15" fill="' . $textColor . '"/>
  <circle cx="600" cy="300" r="15" fill="' . $textColor . '"/>
</svg>';

        // Save SVG to storage
        Storage::disk('public')->put($filepath, $svg);

        return $filepath;
    }

    /**
     * Create exercise without image
     */
    public function withoutImage(): static
    {
        return $this->state(fn (array $attributes) => [
            'image' => null,
        ]);
    }

    /**
     * Create exercise and attach random categories after creation
     */
    public function withCategories(): static
    {
        return $this->afterCreating(function (Exercise $exercise) {
            $categories = \App\Models\Category::inRandomOrder()->take(rand(1, 3))->get();
            $exercise->categories()->attach($categories->pluck('id'));
        });
    }

    /**
     * Create exercise with specific categories
     */
    public function withSpecificCategories(array $categoryNames): static
    {
        return $this->afterCreating(function (Exercise $exercise) use ($categoryNames) {
            $categories = \App\Models\Category::whereIn('name', $categoryNames)->get();
            $exercise->categories()->attach($categories->pluck('id'));
        });
    }
}
