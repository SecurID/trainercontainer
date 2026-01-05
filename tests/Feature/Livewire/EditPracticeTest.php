<?php

use App\Livewire\EditPractice;
use App\Models\Practice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->practice = Practice::factory()->create([
        'user_id' => $this->user->id,
        'topic' => 'Original Topic',
        'date' => '2024-06-15',
        'playerCount' => 10,
        'goalkeeperCount' => 2,
        'notes' => 'Original notes',
    ]);
});

it('renders edit practice component', function () {
    Livewire::test(EditPractice::class, ['practice' => $this->practice])
        ->assertStatus(200);
});

it('loads practice data on mount', function () {
    Livewire::test(EditPractice::class, ['practice' => $this->practice])
        ->assertSet('topic', 'Original Topic')
        ->assertSet('date', '2024-06-15')
        ->assertSet('playerCount', 10)
        ->assertSet('goalkeeperCount', 2)
        ->assertSet('notes', 'Original notes');
});

it('updates topic on change', function () {
    Livewire::test(EditPractice::class, ['practice' => $this->practice])
        ->set('topic', 'Updated Topic')
        ->assertSet('successMessage', 'Gespeichert!');

    $this->practice->refresh();
    expect($this->practice->topic)->toBe('Updated Topic');
});

it('updates date on change', function () {
    Livewire::test(EditPractice::class, ['practice' => $this->practice])
        ->set('date', '2024-07-20')
        ->assertSet('successMessage', 'Gespeichert!');

    $this->practice->refresh();
    expect($this->practice->date->format('Y-m-d'))->toBe('2024-07-20');
});

it('updates player count on change', function () {
    Livewire::test(EditPractice::class, ['practice' => $this->practice])
        ->set('playerCount', 15)
        ->assertSet('successMessage', 'Gespeichert!');

    $this->practice->refresh();
    expect($this->practice->playerCount)->toBe(15);
});

it('updates goalkeeper count on change', function () {
    Livewire::test(EditPractice::class, ['practice' => $this->practice])
        ->set('goalkeeperCount', 3)
        ->assertSet('successMessage', 'Gespeichert!');

    $this->practice->refresh();
    expect($this->practice->goalkeeperCount)->toBe(3);
});

it('updates notes on change', function () {
    Livewire::test(EditPractice::class, ['practice' => $this->practice])
        ->set('notes', 'Updated notes content')
        ->assertSet('successMessage', 'Gespeichert!');

    $this->practice->refresh();
    expect($this->practice->notes)->toBe('Updated notes content');
});

it('can set notes content via method', function () {
    Livewire::test(EditPractice::class, ['practice' => $this->practice])
        ->call('setNotesContent', 'Content from method')
        ->assertSet('notes', 'Content from method')
        ->assertSet('successMessage', 'Gespeichert!');

    $this->practice->refresh();
    expect($this->practice->notes)->toBe('Content from method');
});

it('can save notes via method', function () {
    Livewire::test(EditPractice::class, ['practice' => $this->practice])
        ->set('notes', 'Notes to save')
        ->call('saveNotes')
        ->assertSet('successMessage', 'Gespeichert!');

    $this->practice->refresh();
    expect($this->practice->notes)->toBe('Notes to save');
});

it('can clear success message', function () {
    Livewire::test(EditPractice::class, ['practice' => $this->practice])
        ->set('topic', 'New Topic')
        ->assertSet('successMessage', 'Gespeichert!')
        ->call('clearSuccessMessage')
        ->assertSet('successMessage', '');
});
