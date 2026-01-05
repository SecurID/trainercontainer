<?php

use App\Livewire\CreateGame;
use App\Models\Game;
use App\Models\Opponent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->opponent = Opponent::factory()->for($this->user)->create();
});

it('renders create game component', function () {
    Livewire::test(CreateGame::class)
        ->assertStatus(200);
});

it('initializes with current date', function () {
    Livewire::test(CreateGame::class)
        ->assertSet('date', date('Y-m-d'));
});

it('loads opponents for authenticated user', function () {
    $component = Livewire::test(CreateGame::class);

    expect($component->viewData('opponents'))->toHaveCount(1);
});

it('loads available formations', function () {
    $component = Livewire::test(CreateGame::class);

    expect($component->viewData('formations'))->toBe(Game::FORMATIONS);
});

it('does not load opponents from other users', function () {
    $otherUser = User::factory()->create();
    Opponent::factory()->for($otherUser)->create();

    $component = Livewire::test(CreateGame::class);

    expect($component->viewData('opponents'))->toHaveCount(1);
});

it('creates a game with required fields', function () {
    Livewire::test(CreateGame::class)
        ->set('opponent_id', $this->opponent->id)
        ->set('date', '2024-06-15')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('games.index'));

    expect(Game::where('opponent_id', $this->opponent->id)->exists())->toBeTrue();
});

it('creates a game with all fields', function () {
    Livewire::test(CreateGame::class)
        ->set('opponent_id', $this->opponent->id)
        ->set('opponent_formation', '4-3-3')
        ->set('date', '2024-06-15')
        ->set('time', '15:00')
        ->set('location', 'Home Stadium')
        ->set('notes', 'Important match')
        ->call('save')
        ->assertHasNoErrors();

    $game = Game::where('opponent_id', $this->opponent->id)->first();
    expect($game->opponent_formation)->toBe('4-3-3')
        ->and($game->location)->toBe('Home Stadium')
        ->and($game->notes)->toBe('Important match');
});

it('requires opponent_id', function () {
    Livewire::test(CreateGame::class)
        ->set('opponent_id', '')
        ->set('date', '2024-06-15')
        ->call('save')
        ->assertHasErrors(['opponent_id']);
});

it('requires date', function () {
    Livewire::test(CreateGame::class)
        ->set('opponent_id', $this->opponent->id)
        ->set('date', '')
        ->call('save')
        ->assertHasErrors(['date']);
});

it('validates opponent_id exists', function () {
    Livewire::test(CreateGame::class)
        ->set('opponent_id', 9999)
        ->set('date', '2024-06-15')
        ->call('save')
        ->assertHasErrors(['opponent_id']);
});

it('validates formation is valid', function () {
    Livewire::test(CreateGame::class)
        ->set('opponent_id', $this->opponent->id)
        ->set('opponent_formation', 'invalid-formation')
        ->set('date', '2024-06-15')
        ->call('save')
        ->assertHasErrors(['opponent_formation']);
});

it('allows null formation', function () {
    Livewire::test(CreateGame::class)
        ->set('opponent_id', $this->opponent->id)
        ->set('opponent_formation', null)
        ->set('date', '2024-06-15')
        ->call('save')
        ->assertHasNoErrors();
});

it('associates game with authenticated user', function () {
    Livewire::test(CreateGame::class)
        ->set('opponent_id', $this->opponent->id)
        ->set('date', '2024-06-15')
        ->call('save');

    $game = Game::where('opponent_id', $this->opponent->id)->first();
    expect($game->user_id)->toBe($this->user->id);
});

it('validates location max length', function () {
    Livewire::test(CreateGame::class)
        ->set('opponent_id', $this->opponent->id)
        ->set('date', '2024-06-15')
        ->set('location', str_repeat('a', 256))
        ->call('save')
        ->assertHasErrors(['location']);
});
