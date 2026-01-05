<?php

use App\Livewire\GameRatingsTable;
use App\Models\Game;
use App\Models\Player;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->game = Game::factory()->create(['user_id' => $this->user->id]);
});

it('renders game ratings table component', function () {
    $this->actingAs($this->user);

    Livewire::test(GameRatingsTable::class, ['game' => $this->game])
        ->assertStatus(200);
});

it('loads players for authenticated user', function () {
    $this->actingAs($this->user);
    Player::factory()->count(3)->create(['user_id' => $this->user->id]);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game]);

    expect($component->get('players'))->toHaveCount(3);
});

it('initializes ratings array for players', function () {
    $this->actingAs($this->user);
    $players = Player::factory()->count(2)->create(['user_id' => $this->user->id]);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game]);

    foreach ($players as $player) {
        expect($component->get('ratings'))->toHaveKey($player->id);
    }
});

it('initializes attendances array for players', function () {
    $this->actingAs($this->user);
    $players = Player::factory()->count(2)->create(['user_id' => $this->user->id]);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game]);

    foreach ($players as $player) {
        expect($component->get('attendances'))->toHaveKey($player->id);
    }
});

it('loads existing ratings on mount', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Rating::factory()->create([
        'game_id' => $this->game->id,
        'player_id' => $player->id,
        'user_id' => $this->user->id,
        'rating' => 8,
        'attended' => true,
    ]);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game]);

    expect($component->get('ratings')[$player->id])->toBe(8);
});

it('starts collapsed by default', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game]);

    expect($component->get('isCollapsed'))->toBeTrue();
});

it('can toggle collapse state', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game])
        ->call('toggleCollapse');

    expect($component->get('isCollapsed'))->toBeFalse();

    $component->call('toggleCollapse');

    expect($component->get('isCollapsed'))->toBeTrue();
});

it('clears rating when marking as not attended', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game])
        ->set('ratings.'.$player->id, 7)
        ->set('attendances.'.$player->id, true);

    expect($component->get('ratings')[$player->id])->toBeNull();
});

it('clears not attended when setting a rating', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game])
        ->set('attendances.'.$player->id, true)
        ->set('ratings.'.$player->id, 8);

    expect($component->get('attendances')[$player->id])->toBeFalse();
});

it('saves ratings for players', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(GameRatingsTable::class, ['game' => $this->game])
        ->set('ratings.'.$player->id, 9)
        ->call('saveRatings');

    $this->assertDatabaseHas('ratings', [
        'game_id' => $this->game->id,
        'player_id' => $player->id,
        'rating' => 9,
        'attended' => true,
    ]);
});

it('saves attendance status', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(GameRatingsTable::class, ['game' => $this->game])
        ->set('attendances.'.$player->id, true)
        ->call('saveRatings');

    $this->assertDatabaseHas('ratings', [
        'game_id' => $this->game->id,
        'player_id' => $player->id,
        'attended' => false,
    ]);
});

it('saves ratings for multiple players', function () {
    $this->actingAs($this->user);
    $players = Player::factory()->count(3)->create(['user_id' => $this->user->id]);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game]);

    foreach ($players as $index => $player) {
        $component->set('ratings.'.$player->id, 5 + $index);
    }

    $component->call('saveRatings');

    foreach ($players as $index => $player) {
        $this->assertDatabaseHas('ratings', [
            'game_id' => $this->game->id,
            'player_id' => $player->id,
            'rating' => 5 + $index,
        ]);
    }
});

it('updates existing ratings', function () {
    $this->actingAs($this->user);
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    Rating::factory()->create([
        'game_id' => $this->game->id,
        'player_id' => $player->id,
        'user_id' => $this->user->id,
        'rating' => 5,
    ]);

    Livewire::test(GameRatingsTable::class, ['game' => $this->game])
        ->set('ratings.'.$player->id, 10)
        ->call('saveRatings');

    $this->assertDatabaseHas('ratings', [
        'game_id' => $this->game->id,
        'player_id' => $player->id,
        'rating' => 10,
    ]);

    expect(Rating::where('game_id', $this->game->id)->where('player_id', $player->id)->count())->toBe(1);
});

it('does not load players from other users', function () {
    $this->actingAs($this->user);
    $otherUser = User::factory()->create();

    Player::factory()->count(2)->create(['user_id' => $this->user->id]);
    Player::factory()->count(3)->create(['user_id' => $otherUser->id]);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game]);

    expect($component->get('players'))->toHaveCount(2);
});

it('sets success flag after saving', function () {
    $this->actingAs($this->user);
    Player::factory()->create(['user_id' => $this->user->id]);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game])
        ->call('saveRatings');

    expect($component->get('success'))->toBeTrue();
});

it('orders players by lastname', function () {
    $this->actingAs($this->user);

    Player::factory()->create(['user_id' => $this->user->id, 'lastname' => 'Zimmermann']);
    Player::factory()->create(['user_id' => $this->user->id, 'lastname' => 'Abel']);
    Player::factory()->create(['user_id' => $this->user->id, 'lastname' => 'Mueller']);

    $component = Livewire::test(GameRatingsTable::class, ['game' => $this->game]);

    $players = $component->get('players');
    expect($players->first()->lastname)->toBe('Abel');
    expect($players->last()->lastname)->toBe('Zimmermann');
});
