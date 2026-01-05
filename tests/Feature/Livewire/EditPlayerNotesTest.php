<?php

use App\Livewire\EditPlayerNotes;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('renders edit player notes component', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(EditPlayerNotes::class, ['player' => $player])
        ->assertStatus(200);
});

it('loads player notes on mount', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'notes' => 'Test player notes',
    ]);

    $component = Livewire::test(EditPlayerNotes::class, ['player' => $player]);

    expect($component->get('notes'))->toBe('Test player notes');
});

it('saves player notes', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'notes' => 'Original notes',
    ]);

    Livewire::test(EditPlayerNotes::class, ['player' => $player])
        ->set('notes', 'Updated notes')
        ->call('save')
        ->assertDispatched('saved');

    $this->assertDatabaseHas('players', [
        'id' => $player->id,
        'notes' => 'Updated notes',
    ]);
});

it('handles null notes', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'notes' => null,
    ]);

    $component = Livewire::test(EditPlayerNotes::class, ['player' => $player]);

    expect($component->get('notes'))->toBeNull();
});

it('can clear notes', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'notes' => 'Some notes',
    ]);

    Livewire::test(EditPlayerNotes::class, ['player' => $player])
        ->set('notes', null)
        ->call('save');

    $this->assertDatabaseHas('players', [
        'id' => $player->id,
        'notes' => null,
    ]);
});

it('denies access to other users player on mount', function () {
    $this->actingAs($this->user);
    $otherUser = User::factory()->create();
    $player = Player::factory()->create(['user_id' => $otherUser->id]);

    Livewire::test(EditPlayerNotes::class, ['player' => $player])
        ->assertForbidden();
});

it('denies save for other users player', function () {
    $otherUser = User::factory()->create();
    $player = Player::factory()->create(['user_id' => $otherUser->id]);

    $this->actingAs($this->user);

    Livewire::test(EditPlayerNotes::class, ['player' => $player])
        ->assertForbidden();
});
