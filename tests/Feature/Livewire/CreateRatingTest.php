<?php

use App\Livewire\CreateRating;
use App\Models\Player;
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
        'date' => now()->addDay(),
    ]);
    $this->player = Player::factory()->for($this->user)->create();
});

it('renders create rating component', function () {
    Livewire::test(CreateRating::class)
        ->assertStatus(200);
});

it('loads practices for authenticated user', function () {
    $component = Livewire::test(CreateRating::class);

    expect($component->get('practices'))->toHaveCount(1);
});

it('loads players for authenticated user', function () {
    $component = Livewire::test(CreateRating::class);

    expect($component->get('players'))->toHaveCount(1);
});

it('pre-selects next future practice', function () {
    $futurePractice = Practice::factory()->create([
        'user_id' => $this->user->id,
        'date' => now()->addDays(2),
    ]);

    $component = Livewire::test(CreateRating::class);

    expect($component->get('selectedPractice'))->toBe($this->practice->id);
});

it('does not load practices from other users', function () {
    $otherUser = User::factory()->create();
    Practice::factory()->create(['user_id' => $otherUser->id]);

    $component = Livewire::test(CreateRating::class);

    expect($component->get('practices'))->toHaveCount(1);
});

it('does not load players from other users', function () {
    $otherUser = User::factory()->create();
    Player::factory()->for($otherUser)->create();

    $component = Livewire::test(CreateRating::class);

    expect($component->get('players'))->toHaveCount(1);
});

it('can set ratings for players', function () {
    Livewire::test(CreateRating::class)
        ->set('selectedPractice', $this->practice->id)
        ->set('ratings', [$this->player->id => 8])
        ->assertSet('ratings.'.$this->player->id, 8);
});

it('can select a practice', function () {
    $anotherPractice = Practice::factory()->create([
        'user_id' => $this->user->id,
        'date' => now()->addDays(5),
    ]);

    Livewire::test(CreateRating::class)
        ->set('selectedPractice', $anotherPractice->id)
        ->assertSet('selectedPractice', $anotherPractice->id);
});

it('orders players by lastname', function () {
    $playerA = Player::factory()->for($this->user)->create(['lastname' => 'Alpha']);
    $playerZ = Player::factory()->for($this->user)->create(['lastname' => 'Zeta']);

    $component = Livewire::test(CreateRating::class);

    $players = $component->get('players');
    expect($players->first()->lastname)->toBe('Alpha');
});

it('orders practices by date ascending', function () {
    $laterPractice = Practice::factory()->create([
        'user_id' => $this->user->id,
        'date' => now()->addDays(10),
    ]);

    $component = Livewire::test(CreateRating::class);

    $practices = $component->get('practices');
    expect($practices->first()->id)->toBe($this->practice->id);
});
