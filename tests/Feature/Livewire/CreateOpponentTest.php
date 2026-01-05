<?php

use App\Livewire\CreateOpponent;
use App\Models\Opponent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders create opponent component', function () {
    Livewire::test(CreateOpponent::class)
        ->assertStatus(200);
});

it('creates an opponent with name only', function () {
    Livewire::test(CreateOpponent::class)
        ->set('name', 'FC Bayern')
        ->call('save')
        ->assertHasNoErrors();

    expect(Opponent::where('name', 'FC Bayern')->exists())->toBeTrue();
});

it('creates an opponent with name and notes', function () {
    Livewire::test(CreateOpponent::class)
        ->set('name', 'Borussia Dortmund')
        ->set('notes', 'Strong defense')
        ->call('save')
        ->assertHasNoErrors();

    $opponent = Opponent::where('name', 'Borussia Dortmund')->first();
    expect($opponent->notes)->toBe('Strong defense');
});

it('requires name', function () {
    Livewire::test(CreateOpponent::class)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors(['name' => 'required']);
});

it('validates name max length', function () {
    Livewire::test(CreateOpponent::class)
        ->set('name', str_repeat('a', 256))
        ->call('save')
        ->assertHasErrors(['name' => 'max']);
});

it('resets form after save', function () {
    Livewire::test(CreateOpponent::class)
        ->set('name', 'Test Opponent')
        ->set('notes', 'Test notes')
        ->call('save')
        ->assertSet('name', '')
        ->assertSet('notes', '');
});

it('associates opponent with authenticated user', function () {
    Livewire::test(CreateOpponent::class)
        ->set('name', 'User Opponent')
        ->call('save');

    $opponent = Opponent::where('name', 'User Opponent')->first();
    expect($opponent->user_id)->toBe($this->user->id);
});

it('allows nullable notes', function () {
    Livewire::test(CreateOpponent::class)
        ->set('name', 'No Notes Team')
        ->set('notes', '')
        ->call('save')
        ->assertHasNoErrors();

    expect(Opponent::where('name', 'No Notes Team')->exists())->toBeTrue();
});
