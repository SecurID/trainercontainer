<?php

use App\Livewire\CreatePractice;
use App\Models\Exercise;
use App\Models\Practice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->exercise = Exercise::factory()->withoutImage()->for($this->user)->create();
});

it('renders create practice component', function () {
    Livewire::test(CreatePractice::class)
        ->assertStatus(200);
});

it('initializes with current date and one row', function () {
    Livewire::test(CreatePractice::class)
        ->assertSet('date', date('d.m.Y'))
        ->assertCount('rows', 1);
});

it('can add a row', function () {
    Livewire::test(CreatePractice::class)
        ->assertCount('rows', 1)
        ->call('addRow')
        ->assertCount('rows', 2);
});

it('can remove a row', function () {
    Livewire::test(CreatePractice::class)
        ->call('addRow')
        ->assertCount('rows', 2)
        ->call('removeRow', 0)
        ->assertCount('rows', 1);
});

it('creates a practice with valid data', function () {
    $component = Livewire::test(CreatePractice::class)
        ->set('topic', 'Test Training')
        ->set('rows.0.exerciseId', $this->exercise->id)
        ->set('rows.0.exercise', $this->exercise->name)
        ->set('rows.0.coaches', 'Coach A')
        ->set('rows.0.time', '15')
        ->set('rows.0.playerCount', 10)
        ->set('rows.0.goalkeeperCount', 1)
        ->call('save')
        ->assertRedirect(route('practices.index'));

    expect(Practice::where('topic', 'Test Training')->exists())->toBeTrue();
});

it('requires topic', function () {
    Livewire::test(CreatePractice::class)
        ->set('topic', '')
        ->set('rows.0.exerciseId', $this->exercise->id)
        ->set('rows.0.coaches', 'Coach A')
        ->set('rows.0.time', '15')
        ->set('rows.0.playerCount', 10)
        ->set('rows.0.goalkeeperCount', 1)
        ->call('save')
        ->assertHasErrors(['topic']);
});

it('requires exercise id in rows', function () {
    Livewire::test(CreatePractice::class)
        ->set('topic', 'Test Training')
        ->set('rows.0.exerciseId', '')
        ->set('rows.0.coaches', 'Coach A')
        ->set('rows.0.time', '15')
        ->set('rows.0.playerCount', 10)
        ->set('rows.0.goalkeeperCount', 1)
        ->call('save')
        ->assertHasErrors(['rows.0.exerciseId']);
});

it('associates practice with authenticated user', function () {
    Livewire::test(CreatePractice::class)
        ->set('topic', 'User Practice')
        ->set('rows.0.exerciseId', $this->exercise->id)
        ->set('rows.0.exercise', $this->exercise->name)
        ->set('rows.0.coaches', 'Coach A')
        ->set('rows.0.time', '15')
        ->set('rows.0.playerCount', 10)
        ->set('rows.0.goalkeeperCount', 1)
        ->call('save');

    $practice = Practice::where('topic', 'User Practice')->first();
    expect($practice->user_id)->toBe($this->user->id);
});

it('creates schedules for each row', function () {
    Livewire::test(CreatePractice::class)
        ->set('topic', 'Multi Schedule Practice')
        ->set('rows.0.exerciseId', $this->exercise->id)
        ->set('rows.0.exercise', $this->exercise->name)
        ->set('rows.0.coaches', 'Coach A')
        ->set('rows.0.time', '15')
        ->set('rows.0.playerCount', 10)
        ->set('rows.0.goalkeeperCount', 1)
        ->call('addRow')
        ->set('rows.1.exerciseId', $this->exercise->id)
        ->set('rows.1.exercise', $this->exercise->name)
        ->set('rows.1.coaches', 'Coach B')
        ->set('rows.1.time', '20')
        ->set('rows.1.playerCount', 8)
        ->set('rows.1.goalkeeperCount', 2)
        ->call('save');

    $practice = Practice::where('topic', 'Multi Schedule Practice')->first();
    expect($practice->schedules->count())->toBe(2);
});
