<?php

namespace Tests\Feature;

use App\Models\Exercise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExerciseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        Exercise::factory()->count(3)->create([
            'user_id' => auth()->id(),
        ]);
        $response = $this->get(route('exercises.index'));
        $response->assertStatus(200);
        $response->assertViewIs('exercises.exercises');
        $response->assertViewHas('exercises', function ($exercises) {
            return $exercises->count() === 3;
        });
    }
}
