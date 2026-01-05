<?php

use App\Livewire\PracticeRatingsTable;
use App\Models\Player;
use App\Models\Practice;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->practice = Practice::factory()->create(['user_id' => $this->user->id]);
    $this->player = Player::factory()->for($this->user)->create();
});

it('renders practice ratings table component', function () {
    Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice])
        ->assertStatus(200);
});

it('loads players for authenticated user', function () {
    $component = Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice]);

    expect($component->get('players'))->toHaveCount(1);
});

it('initializes ratings array for players', function () {
    $component = Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice]);

    expect($component->get('ratings'))->toHaveKey($this->player->id);
});

it('initializes attendances array for players', function () {
    $component = Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice]);

    expect($component->get('attendances'))->toHaveKey($this->player->id);
});

it('loads existing ratings on mount', function () {
    Rating::create([
        'player_id' => $this->player->id,
        'practice_id' => $this->practice->id,
        'user_id' => $this->user->id,
        'rating' => 8,
        'attended' => true,
    ]);

    $component = Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice]);

    expect($component->get('ratings')[$this->player->id])->toBe(8);
});

it('starts collapsed by default', function () {
    Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice])
        ->assertSet('isCollapsed', true);
});

it('can toggle collapse state', function () {
    Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice])
        ->assertSet('isCollapsed', true)
        ->call('toggleCollapse')
        ->assertSet('isCollapsed', false)
        ->call('toggleCollapse')
        ->assertSet('isCollapsed', true);
});

it('clears rating when marking as not attended', function () {
    Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice])
        ->set('ratings', [$this->player->id => 7])
        ->set('attendances.'.$this->player->id, true)
        ->assertSet('ratings.'.$this->player->id, null);
});

it('clears not attended when setting a rating', function () {
    Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice])
        ->set('attendances.'.$this->player->id, true)
        ->set('ratings.'.$this->player->id, 8)
        ->assertSet('attendances.'.$this->player->id, false);
});

it('saves ratings for players', function () {
    Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice])
        ->set('ratings', [$this->player->id => 7])
        ->set('attendances', [$this->player->id => false])
        ->call('saveRatings')
        ->assertSet('success', true);

    expect(Rating::where('player_id', $this->player->id)
        ->where('practice_id', $this->practice->id)
        ->where('rating', 7)
        ->exists())->toBeTrue();
});

it('saves attendance status', function () {
    Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice])
        ->set('ratings', [$this->player->id => null])
        ->set('attendances', [$this->player->id => true])
        ->call('saveRatings');

    $rating = Rating::where('player_id', $this->player->id)
        ->where('practice_id', $this->practice->id)
        ->first();

    expect($rating->attended)->toBeFalse();
});

it('saves ratings for multiple players', function () {
    $player2 = Player::factory()->for($this->user)->create();

    Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice])
        ->set('ratings', [
            $this->player->id => 8,
            $player2->id => 6,
        ])
        ->set('attendances', [
            $this->player->id => false,
            $player2->id => false,
        ])
        ->call('saveRatings');

    expect(Rating::where('practice_id', $this->practice->id)->count())->toBe(2);
});

it('updates existing ratings', function () {
    $existingRating = Rating::create([
        'player_id' => $this->player->id,
        'practice_id' => $this->practice->id,
        'user_id' => $this->user->id,
        'rating' => 5,
        'attended' => true,
    ]);

    Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice])
        ->set('ratings', [$this->player->id => 9])
        ->set('attendances', [$this->player->id => false])
        ->call('saveRatings');

    $existingRating->refresh();
    expect($existingRating->rating)->toBe(9);
});

it('does not load players from other users', function () {
    $otherUser = User::factory()->create();
    Player::factory()->for($otherUser)->create();

    $component = Livewire::test(PracticeRatingsTable::class, ['practice' => $this->practice]);

    expect($component->get('players'))->toHaveCount(1);
});
