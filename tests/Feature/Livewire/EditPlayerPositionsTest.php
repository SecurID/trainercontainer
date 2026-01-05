<?php

use App\Livewire\EditPlayerPositions;
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

it('renders edit player positions component', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(EditPlayerPositions::class, ['player' => $player])
        ->assertStatus(200);
});

it('loads player main position on mount', function () {
    $this->actingAs($this->user);
    $position = $this->positions->first();
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'main_position_id' => $position->id,
    ]);

    $component = Livewire::test(EditPlayerPositions::class, ['player' => $player]);

    expect($component->get('main_position_id'))->toBe($position->id);
});

it('loads player sub positions on mount', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);
    $subPositions = $this->positions->take(2);
    $player->subPositions()->attach($subPositions->pluck('id'));

    $component = Livewire::test(EditPlayerPositions::class, ['player' => $player]);

    expect($component->get('sub_position_ids'))->toHaveCount(2);
});

it('saves main position', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);
    $position = $this->positions->first();

    Livewire::test(EditPlayerPositions::class, ['player' => $player])
        ->set('main_position_id', $position->id)
        ->call('save')
        ->assertDispatched('saved');

    $this->assertDatabaseHas('players', [
        'id' => $player->id,
        'main_position_id' => $position->id,
    ]);
});

it('saves sub positions', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);
    $subPositions = $this->positions->take(3)->pluck('id')->toArray();

    Livewire::test(EditPlayerPositions::class, ['player' => $player])
        ->set('sub_position_ids', $subPositions)
        ->call('save');

    expect($player->fresh()->subPositions()->count())->toBe(3);
});

it('validates main position exists', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(EditPlayerPositions::class, ['player' => $player])
        ->set('main_position_id', 99999)
        ->call('save')
        ->assertHasErrors(['main_position_id']);
});

it('validates sub positions exist', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(EditPlayerPositions::class, ['player' => $player])
        ->set('sub_position_ids', [99999])
        ->call('save')
        ->assertHasErrors(['sub_position_ids.0']);
});

it('allows null main position', function () {
    $this->actingAs($this->user);
    $position = $this->positions->first();
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'main_position_id' => $position->id,
    ]);

    Livewire::test(EditPlayerPositions::class, ['player' => $player])
        ->set('main_position_id', null)
        ->call('save');

    $this->assertDatabaseHas('players', [
        'id' => $player->id,
        'main_position_id' => null,
    ]);
});

it('syncs sub positions on save', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);
    $oldPositions = $this->positions->take(2);
    $player->subPositions()->attach($oldPositions->pluck('id'));

    $newPositions = $this->positions->slice(2, 2)->pluck('id')->toArray();

    Livewire::test(EditPlayerPositions::class, ['player' => $player])
        ->set('sub_position_ids', $newPositions)
        ->call('save');

    $player->refresh();
    expect($player->subPositions()->count())->toBe(2);
    expect($player->subPositions->pluck('id')->toArray())->toBe($newPositions);
});

it('denies access to other users player on mount', function () {
    $this->actingAs($this->user);
    $otherUser = User::factory()->create();
    $player = Player::factory()->create(['user_id' => $otherUser->id]);

    Livewire::test(EditPlayerPositions::class, ['player' => $player])
        ->assertForbidden();
});

it('displays available positions', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(EditPlayerPositions::class, ['player' => $player])
        ->assertViewHas('positions', fn ($positions) => $positions->count() === 5);
});
