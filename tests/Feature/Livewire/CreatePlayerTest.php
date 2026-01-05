<?php

use App\Livewire\CreatePlayer;
use App\Models\Player;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    // Create positions for testing
    Position::create(['name' => 'Goalkeeper', 'abbreviation' => 'GK', 'description' => 'Goalkeeper']);
    Position::create(['name' => 'Striker', 'abbreviation' => 'ST', 'description' => 'Striker']);
});

it('renders create player component', function () {
    Livewire::test(CreatePlayer::class)
        ->assertStatus(200)
        ->assertSee('GK')
        ->assertSee('ST');
});

it('creates a player with required fields', function () {
    Livewire::test(CreatePlayer::class)
        ->set('prename', 'John')
        ->set('lastname', 'Doe')
        ->call('save')
        ->assertHasNoErrors();

    expect(Player::where('prename', 'John')->where('lastname', 'Doe')->exists())->toBeTrue();
});

it('creates a player with main position', function () {
    $position = Position::first();

    Livewire::test(CreatePlayer::class)
        ->set('prename', 'Jane')
        ->set('lastname', 'Smith')
        ->set('main_position_id', $position->id)
        ->call('save')
        ->assertHasNoErrors();

    $player = Player::where('prename', 'Jane')->first();
    expect($player->main_position_id)->toBe($position->id);
});

it('creates a player with sub positions', function () {
    $positions = Position::all();

    Livewire::test(CreatePlayer::class)
        ->set('prename', 'Bob')
        ->set('lastname', 'Johnson')
        ->set('sub_position_ids', $positions->pluck('id')->toArray())
        ->call('save')
        ->assertHasNoErrors();

    $player = Player::where('prename', 'Bob')->first();
    expect($player->subPositions->count())->toBe(2);
});

it('requires prename', function () {
    Livewire::test(CreatePlayer::class)
        ->set('prename', '')
        ->set('lastname', 'Doe')
        ->call('save')
        ->assertHasErrors(['prename' => 'required']);
});

it('requires lastname', function () {
    Livewire::test(CreatePlayer::class)
        ->set('prename', 'John')
        ->set('lastname', '')
        ->call('save')
        ->assertHasErrors(['lastname' => 'required']);
});

it('validates main_position_id exists', function () {
    Livewire::test(CreatePlayer::class)
        ->set('prename', 'John')
        ->set('lastname', 'Doe')
        ->set('main_position_id', 9999)
        ->call('save')
        ->assertHasErrors(['main_position_id']);
});

it('resets form after save', function () {
    Livewire::test(CreatePlayer::class)
        ->set('prename', 'John')
        ->set('lastname', 'Doe')
        ->call('save')
        ->assertSet('prename', '')
        ->assertSet('lastname', '')
        ->assertSet('main_position_id', null)
        ->assertSet('sub_position_ids', []);
});

it('associates player with authenticated user', function () {
    Livewire::test(CreatePlayer::class)
        ->set('prename', 'Test')
        ->set('lastname', 'Player')
        ->call('save');

    $player = Player::where('prename', 'Test')->first();
    expect($player->user_id)->toBe($this->user->id);
});
