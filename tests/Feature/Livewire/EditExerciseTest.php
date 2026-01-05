<?php

use App\Livewire\EditExercise;
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
    $this->exercise = Exercise::factory()->withoutImage()->for($this->user)->create();
});

it('renders edit exercise component', function () {
    Livewire::test(EditExercise::class, ['exercise' => $this->exercise])
        ->assertStatus(200);
});

it('loads exercise data on mount', function () {
    Livewire::test(EditExercise::class, ['exercise' => $this->exercise])
        ->assertSet('name', $this->exercise->name)
        ->assertSet('focus', $this->exercise->focus)
        ->assertSet('material', $this->exercise->material);
});

it('loads categories on mount', function () {
    $category = Category::create(['name' => 'Passing']);

    $component = Livewire::test(EditExercise::class, ['exercise' => $this->exercise]);

    expect($component->get('categoriesList'))->toHaveCount(1);
});

it('denies access to other users exercise', function () {
    $otherUser = User::factory()->create();
    $otherExercise = Exercise::factory()->withoutImage()->for($otherUser)->create();

    Livewire::test(EditExercise::class, ['exercise' => $otherExercise])
        ->assertForbidden();
});

it('updates exercise with valid data', function () {
    Livewire::test(EditExercise::class, ['exercise' => $this->exercise])
        ->set('name', 'Updated Exercise')
        ->set('focus', 'New Focus')
        ->call('update')
        ->assertHasNoErrors()
        ->assertRedirect(route('exercises.index'));

    $this->exercise->refresh();
    expect($this->exercise->name)->toBe('Updated Exercise')
        ->and($this->exercise->focus)->toBe('New Focus');
});

it('updates exercise with new image', function () {
    $image = UploadedFile::fake()->image('new-exercise.jpg', 800, 600);

    Livewire::test(EditExercise::class, ['exercise' => $this->exercise])
        ->set('name', $this->exercise->name)
        ->set('image', $image)
        ->call('update')
        ->assertHasNoErrors();

    $this->exercise->refresh();
    expect($this->exercise->image)->not->toBeNull();
    Storage::disk('public')->assertExists($this->exercise->image);
});

it('updates exercise categories', function () {
    $category1 = Category::create(['name' => 'Passing']);
    $category2 = Category::create(['name' => 'Shooting']);

    Livewire::test(EditExercise::class, ['exercise' => $this->exercise])
        ->set('name', $this->exercise->name)
        ->set('categories', [$category1->id, $category2->id])
        ->call('update')
        ->assertHasNoErrors();

    $this->exercise->refresh();
    expect($this->exercise->categories->count())->toBe(2);
});

it('requires name on update', function () {
    Livewire::test(EditExercise::class, ['exercise' => $this->exercise])
        ->set('name', '')
        ->call('update')
        ->assertHasErrors(['name' => 'required']);
});

it('deletes exercise', function () {
    Livewire::test(EditExercise::class, ['exercise' => $this->exercise])
        ->call('delete')
        ->assertRedirect(route('exercises.index'));

    expect(Exercise::find($this->exercise->id))->toBeNull();
});

it('denies delete for other users exercise', function () {
    $otherUser = User::factory()->create();
    $otherExercise = Exercise::factory()->withoutImage()->for($otherUser)->create();

    $this->actingAs($otherUser);

    Livewire::test(EditExercise::class, ['exercise' => $otherExercise])
        ->assertStatus(200);

    $this->actingAs($this->user);

    Livewire::test(EditExercise::class, ['exercise' => $otherExercise])
        ->assertForbidden();
});

it('loads existing categories for exercise', function () {
    $category = Category::create(['name' => 'Dribbling']);
    $this->exercise->categories()->attach($category->id);

    $component = Livewire::test(EditExercise::class, ['exercise' => $this->exercise]);

    expect($component->get('categories'))->toContain($category->id);
});
