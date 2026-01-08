<?php

use App\Livewire\PlayerDetails;
use App\Models\Player;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->positions = Position::factory()->count(5)->create();
});

it('renders player details component', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(PlayerDetails::class, ['player' => $player])
        ->assertStatus(200);
});

it('loads player data on mount', function () {
    $this->actingAs($this->user);
    $position = $this->positions->first();
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'prename' => 'John',
        'lastname' => 'Doe',
        'main_position_id' => $position->id,
        'notes' => 'Test notes',
    ]);

    $component = Livewire::test(PlayerDetails::class, ['player' => $player]);

    expect($component->get('prename'))->toBe('John');
    expect($component->get('lastname'))->toBe('Doe');
    expect($component->get('main_position_id'))->toBe($position->id);
    expect($component->get('notes'))->toBe('Test notes');
});

it('saves player name', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'prename' => 'John',
        'lastname' => 'Doe',
    ]);

    Livewire::test(PlayerDetails::class, ['player' => $player])
        ->set('prename', 'Jane')
        ->set('lastname', 'Smith')
        ->call('saveName');

    $this->assertDatabaseHas('players', [
        'id' => $player->id,
        'prename' => 'Jane',
        'lastname' => 'Smith',
    ]);
});

it('validates name fields', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(PlayerDetails::class, ['player' => $player])
        ->set('prename', '')
        ->set('lastname', '')
        ->call('saveName')
        ->assertHasErrors(['prename', 'lastname']);
});

it('saves positions', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);
    $position = $this->positions->first();
    $subPositions = $this->positions->slice(1, 2)->pluck('id')->toArray();

    Livewire::test(PlayerDetails::class, ['player' => $player])
        ->set('main_position_id', $position->id)
        ->set('sub_position_ids', $subPositions)
        ->call('savePositions');

    $this->assertDatabaseHas('players', [
        'id' => $player->id,
        'main_position_id' => $position->id,
    ]);
    expect($player->fresh()->subPositions()->count())->toBe(2);
});

it('validates main position exists', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(PlayerDetails::class, ['player' => $player])
        ->set('main_position_id', 99999)
        ->call('savePositions')
        ->assertHasErrors(['main_position_id']);
});

it('saves notes', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'notes' => 'Original notes',
    ]);

    Livewire::test(PlayerDetails::class, ['player' => $player])
        ->set('notes', 'Updated notes')
        ->call('saveNotes');

    $this->assertDatabaseHas('players', [
        'id' => $player->id,
        'notes' => 'Updated notes',
    ]);
});

it('can clear notes', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'notes' => 'Some notes',
    ]);

    Livewire::test(PlayerDetails::class, ['player' => $player])
        ->set('notes', null)
        ->call('saveNotes');

    $this->assertDatabaseHas('players', [
        'id' => $player->id,
        'notes' => null,
    ]);
});

it('dispatches player name updated event', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'prename' => 'John',
        'lastname' => 'Doe',
    ]);

    Livewire::test(PlayerDetails::class, ['player' => $player])
        ->set('prename', 'Jane')
        ->set('lastname', 'Smith')
        ->call('saveName')
        ->assertDispatched('player-name-updated');
});

it('denies access to other users player', function () {
    $this->actingAs($this->user);
    $otherUser = User::factory()->create();
    $player = Player::factory()->create(['user_id' => $otherUser->id]);

    Livewire::test(PlayerDetails::class, ['player' => $player])
        ->call('saveName')
        ->assertForbidden();
});
