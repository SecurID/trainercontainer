<?php

use App\Models\Category;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    Storage::fake('public');
});

it('displays exercises index', function () {
    Exercise::factory()->count(3)->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->get(route('exercises.index'));

    $response->assertStatus(200);
    $response->assertViewIs('exercises.exercises');
    $response->assertViewHas('exercises', fn ($exercises) => $exercises->count() === 3);
});

it('displays exercises with categories loaded', function () {
    $category = Category::factory()->create();
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);
    $exercise->categories()->attach($category->id);

    $response = $this->actingAs($this->user)->get(route('exercises.index'));

    $response->assertStatus(200);
    $response->assertViewHas('categories');
});

it('displays create exercise form', function () {
    Category::factory()->count(3)->create();

    $response = $this->actingAs($this->user)->get(route('exercises.create'));

    $response->assertStatus(200);
    $response->assertViewIs('exercises.create-exercises');
    $response->assertViewHas('categories', fn ($categories) => $categories->count() === 3);
});

it('stores a new exercise', function () {
    $category = Category::factory()->create();

    $data = [
        'name' => 'Test Exercise',
        'focus' => 'Passing',
        'material' => 'Balls, cones',
        'procedure' => 'Do the exercise',
        'coaching' => 'Watch for technique',
        'duration' => '15',
        'intensity' => '70',
        'categories' => [$category->id],
    ];

    $response = $this->actingAs($this->user)->post(route('exercises.store'), $data);

    $response->assertRedirect(route('exercises.index'));

    $this->assertDatabaseHas('exercises', [
        'name' => 'Test Exercise',
        'focus' => 'Passing',
        'user_id' => $this->user->id,
    ]);
});

it('stores exercise with image', function () {
    $category = Category::factory()->create();
    $file = UploadedFile::fake()->image('drawing.jpg');

    $data = [
        'name' => 'Exercise with Image',
        'focus' => 'Shooting',
        'procedure' => 'Shoot the ball',
        'coaching' => 'Aim for corners',
        'categories' => [$category->id],
        'drawing' => $file,
    ];

    $response = $this->actingAs($this->user)->post(route('exercises.store'), $data);

    $response->assertRedirect(route('exercises.index'));

    $exercise = Exercise::where('name', 'Exercise with Image')->first();
    expect($exercise->image)->not->toBeNull();
    Storage::disk('public')->assertExists($exercise->image);
});

it('attaches categories to exercise', function () {
    $categories = Category::factory()->count(2)->create();

    $data = [
        'name' => 'Categorized Exercise',
        'focus' => 'Dribbling',
        'procedure' => 'Dribble around cones',
        'coaching' => 'Keep ball close',
        'categories' => $categories->pluck('id')->toArray(),
    ];

    $this->actingAs($this->user)->post(route('exercises.store'), $data);

    $exercise = Exercise::where('name', 'Categorized Exercise')->first();
    expect($exercise->categories()->count())->toBe(2);
});

it('validates required fields on store', function () {
    $response = $this->actingAs($this->user)->post(route('exercises.store'), []);

    $response->assertSessionHasErrors(['name', 'focus', 'procedure', 'coaching', 'categories']);
});

it('displays exercise details', function () {
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->get(route('exercises.show', $exercise));

    $response->assertStatus(200);
    $response->assertViewIs('exercises.exercise-single');
    $response->assertViewHas('exercise');
});

it('displays edit exercise form', function () {
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);
    Category::factory()->count(3)->create();

    $response = $this->actingAs($this->user)->get(route('exercises.edit', $exercise));

    $response->assertStatus(200);
    $response->assertViewIs('exercises.update-exercises');
    $response->assertViewHas('exercise');
    $response->assertViewHas('categories');
});

it('denies edit for other users exercise', function () {
    $otherUser = User::factory()->create();
    $exercise = Exercise::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($this->user)->get(route('exercises.edit', $exercise));

    $response->assertStatus(403);
});

it('updates an exercise', function () {
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    $data = [
        'name' => 'Updated Exercise',
        'focus' => 'Updated Focus',
        'procedure' => 'Updated procedure',
        'coaching' => 'Updated coaching',
    ];

    $response = $this->actingAs($this->user)->put(route('exercises.update', $exercise), $data);

    $response->assertRedirect(route('exercises.show', $exercise->id));

    $this->assertDatabaseHas('exercises', [
        'id' => $exercise->id,
        'name' => 'Updated Exercise',
    ]);
});

it('updates exercise with new image', function () {
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);
    $file = UploadedFile::fake()->image('new-drawing.png');

    $data = [
        'name' => $exercise->name,
        'focus' => $exercise->focus,
        'procedure' => $exercise->procedure,
        'coaching' => 'Updated coaching',
        'drawing' => $file,
    ];

    $this->actingAs($this->user)->put(route('exercises.update', $exercise), $data);

    $exercise->refresh();
    expect($exercise->image)->not->toBeNull();
    Storage::disk('public')->assertExists($exercise->image);
});

it('syncs categories on update', function () {
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);
    $oldCategory = Category::create(['name' => 'Old Category']);
    $exercise->categories()->attach($oldCategory->id);

    $newCategory1 = Category::create(['name' => 'New Category 1']);
    $newCategory2 = Category::create(['name' => 'New Category 2']);

    $data = [
        'name' => $exercise->name,
        'focus' => $exercise->focus,
        'procedure' => $exercise->procedure,
        'coaching' => $exercise->coaching,
        'categories' => [$newCategory1->id, $newCategory2->id],
    ];

    $response = $this->actingAs($this->user)->put(route('exercises.update', $exercise), $data);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();

    $exercise->refresh();
    expect($exercise->categories()->count())->toBe(2);
    expect($exercise->categories->pluck('id')->sort()->values()->toArray())
        ->toBe([$newCategory1->id, $newCategory2->id]);
});

it('validates required fields on update', function () {
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->put(route('exercises.update', $exercise), []);

    $response->assertSessionHasErrors(['name', 'focus', 'procedure']);
});

it('shows all exercises regardless of owner', function () {
    $otherUser = User::factory()->create();
    Exercise::factory()->count(2)->create(['user_id' => $this->user->id]);
    Exercise::factory()->count(3)->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($this->user)->get(route('exercises.index'));

    $response->assertViewHas('exercises', fn ($exercises) => $exercises->count() === 5);
});
