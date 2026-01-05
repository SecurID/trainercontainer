<?php

use App\Models\Exercise;
use App\Models\Player;
use App\Models\Practice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('displays practices index', function () {
    Practice::factory()->count(3)->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->get(route('practices.index'));

    $response->assertStatus(200);
    $response->assertViewIs('practices.practices');
    $response->assertViewHas('practices', fn ($practices) => $practices->count() === 3);
});

it('only shows practices for authenticated user', function () {
    $otherUser = User::factory()->create();
    Practice::factory()->count(2)->create(['user_id' => $this->user->id]);
    Practice::factory()->count(3)->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($this->user)->get(route('practices.index'));

    $response->assertViewHas('practices', fn ($practices) => $practices->count() === 2);
});

it('displays create practice form', function () {
    $response = $this->actingAs($this->user)->get(route('practices.create'));

    $response->assertStatus(200);
    $response->assertViewIs('practices.create-practices');
});

it('stores a new practice with schedules', function () {
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    $data = [
        'date' => '15.01.2025',
        'topic' => 'Test Training',
        'rows' => [
            [
                'exerciseId' => $exercise->id,
                'coaches' => 'Coach A',
                'time' => '15 min',
                'playerCount' => 10,
                'goalkeeperCount' => 1,
            ],
        ],
    ];

    $response = $this->actingAs($this->user)->postJson(route('practices.store'), $data);

    $response->assertStatus(200);
    $response->assertJson(['message' => 'Practice created successfully']);

    $this->assertDatabaseHas('practices', [
        'topic' => 'Test Training',
        'user_id' => $this->user->id,
    ]);

    $this->assertDatabaseHas('schedules', [
        'exercise_id' => $exercise->id,
        'coaches' => 'Coach A',
    ]);
});

it('stores a practice with multiple schedules', function () {
    $exercise1 = Exercise::factory()->create(['user_id' => $this->user->id]);
    $exercise2 = Exercise::factory()->create(['user_id' => $this->user->id]);

    $data = [
        'date' => '20.01.2025',
        'topic' => 'Full Training',
        'rows' => [
            [
                'exerciseId' => $exercise1->id,
                'coaches' => 'Coach A',
                'time' => '10 min',
                'playerCount' => 8,
                'goalkeeperCount' => 0,
            ],
            [
                'exerciseId' => $exercise2->id,
                'coaches' => 'Coach B',
                'time' => '20 min',
                'playerCount' => 12,
                'goalkeeperCount' => 2,
            ],
        ],
    ];

    $response = $this->actingAs($this->user)->postJson(route('practices.store'), $data);

    $response->assertStatus(200);

    $practice = Practice::where('topic', 'Full Training')->first();
    expect($practice->schedules()->count())->toBe(2);
});

it('validates required fields on store', function () {
    $response = $this->actingAs($this->user)->postJson(route('practices.store'), []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['date', 'topic']);
});

it('displays practice details', function () {
    $practice = Practice::factory()->create(['user_id' => $this->user->id]);
    Player::factory()->count(5)->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->get(route('practices.show', $practice));

    $response->assertStatus(200);
    $response->assertViewIs('practices.practice-single');
    $response->assertViewHas('practice');
    $response->assertViewHas('schedules');
    $response->assertViewHas('players');
});

it('denies access to other users practice', function () {
    $otherUser = User::factory()->create();
    $practice = Practice::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($this->user)->get(route('practices.show', $practice));

    $response->assertStatus(403);
});

it('displays practice schedule view', function () {
    $practice = Practice::factory()->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->get(route('practices.schedule', $practice));

    $response->assertStatus(200);
    $response->assertViewIs('practices.practice-schedule');
    $response->assertViewHas('practice');
    $response->assertViewHas('schedules');
});

it('denies schedule access to other users practice', function () {
    $otherUser = User::factory()->create();
    $practice = Practice::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($this->user)->get(route('practices.schedule', $practice));

    $response->assertStatus(403);
});

it('deletes a practice and its schedules', function () {
    $practice = Practice::factory()->create(['user_id' => $this->user->id]);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);
    $practice->schedules()->create([
        'exercise_id' => $exercise->id,
        'coaches' => 'Test Coach',
        'time' => '15 min',
        'playerCount' => 10,
        'goalkeeperCount' => 1,
    ]);

    $response = $this->actingAs($this->user)->delete(route('practices.destroy', $practice));

    $response->assertRedirect(route('practices.index'));
    $response->assertSessionHas('success-message');

    $this->assertDatabaseMissing('practices', ['id' => $practice->id]);
    $this->assertDatabaseMissing('schedules', ['practice_id' => $practice->id]);
});

it('denies delete for other users practice', function () {
    $otherUser = User::factory()->create();
    $practice = Practice::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($this->user)->delete(route('practices.destroy', $practice));

    $response->assertStatus(403);
});

it('orders practices by date', function () {
    Practice::factory()->create(['user_id' => $this->user->id, 'date' => '2025-03-01']);
    Practice::factory()->create(['user_id' => $this->user->id, 'date' => '2025-01-01']);
    Practice::factory()->create(['user_id' => $this->user->id, 'date' => '2025-02-01']);

    $response = $this->actingAs($this->user)->get(route('practices.index'));

    $practices = $response->viewData('practices');
    expect($practices->first()->date->format('Y-m-d'))->toBe('2025-01-01');
    expect($practices->last()->date->format('Y-m-d'))->toBe('2025-03-01');
});
