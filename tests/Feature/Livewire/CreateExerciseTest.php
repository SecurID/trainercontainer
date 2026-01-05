<?php

use App\Livewire\CreateExercise;
use App\Models\Category;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    Storage::fake('public');
});

it('renders create exercise component', function () {
    Livewire::test(CreateExercise::class)
        ->assertStatus(200);
});

it('loads categories on mount', function () {
    $category = Category::create(['name' => 'Passing']);

    $component = Livewire::test(CreateExercise::class);

    expect($component->get('categoriesList'))->toHaveCount(1);
});

it('creates an exercise with required fields', function () {
    Livewire::test(CreateExercise::class)
        ->set('name', 'Test Exercise')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('exercises.index'));

    expect(Exercise::where('name', 'Test Exercise')->exists())->toBeTrue();
});

it('creates an exercise with all fields', function () {
    Livewire::test(CreateExercise::class)
        ->set('name', 'Complete Exercise')
        ->set('focus', 'Ballbesitz')
        ->set('material', 'Balls, Cones')
        ->set('duration', '15')
        ->set('intensity', '80')
        ->set('playerCount', 10)
        ->set('goalkeeperCount', 2)
        ->set('level', 3)
        ->set('age', 14)
        ->set('procedure', 'Pass the ball around')
        ->set('coaching', 'Keep head up')
        ->call('save')
        ->assertHasNoErrors();

    $exercise = Exercise::where('name', 'Complete Exercise')->first();
    expect($exercise->focus)->toBe('Ballbesitz')
        ->and($exercise->material)->toBe('Balls, Cones')
        ->and($exercise->playerCount)->toBe(10);
});

it('creates an exercise with image', function () {
    $image = UploadedFile::fake()->image('exercise.jpg', 800, 600);

    Livewire::test(CreateExercise::class)
        ->set('name', 'Image Exercise')
        ->set('image', $image)
        ->call('save')
        ->assertHasNoErrors();

    $exercise = Exercise::where('name', 'Image Exercise')->first();
    expect($exercise->image)->not->toBeNull();
    Storage::disk('public')->assertExists($exercise->image);
});

it('creates an exercise with categories', function () {
    $category1 = Category::create(['name' => 'Passing']);
    $category2 = Category::create(['name' => 'Shooting']);

    Livewire::test(CreateExercise::class)
        ->set('name', 'Categorized Exercise')
        ->set('categories', [$category1->id, $category2->id])
        ->call('save')
        ->assertHasNoErrors();

    $exercise = Exercise::where('name', 'Categorized Exercise')->first();
    expect($exercise->categories->count())->toBe(2);
});

it('requires name', function () {
    Livewire::test(CreateExercise::class)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors(['name' => 'required']);
});

it('validates image is a file', function () {
    Livewire::test(CreateExercise::class)
        ->set('name', 'Test')
        ->set('image', 'not-a-file')
        ->call('save')
        ->assertHasErrors(['image']);
});

it('validates image max size', function () {
    $image = UploadedFile::fake()->image('large.jpg')->size(3000);

    Livewire::test(CreateExercise::class)
        ->set('name', 'Test')
        ->set('image', $image)
        ->call('save')
        ->assertHasErrors(['image']);
});

it('associates exercise with authenticated user', function () {
    Livewire::test(CreateExercise::class)
        ->set('name', 'User Exercise')
        ->call('save');

    $exercise = Exercise::where('name', 'User Exercise')->first();
    expect($exercise->user_id)->toBe($this->user->id);
});

it('accepts valid integer for player count', function () {
    Livewire::test(CreateExercise::class)
        ->set('name', 'Test')
        ->set('playerCount', 10)
        ->call('save')
        ->assertHasNoErrors(['playerCount']);
});
