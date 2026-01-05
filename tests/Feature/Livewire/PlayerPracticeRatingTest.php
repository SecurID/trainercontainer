<?php

use App\Livewire\PlayerPracticeRating;
use App\Models\Player;
use App\Models\Practice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->player = Player::factory()->for($this->user)->create();
    $this->practice = Practice::factory()->create(['user_id' => $this->user->id]);
});

it('renders player practice rating component', function () {
    Livewire::test(PlayerPracticeRating::class, [
        'player' => $this->player,
        'practice' => $this->practice,
    ])->assertStatus(200);
});

it('initializes with null value when no rating exists', function () {
    Livewire::test(PlayerPracticeRating::class, [
        'player' => $this->player,
        'practice' => $this->practice,
    ])
        ->assertSet('value', null)
        ->assertSet('ratingId', null);
});

it('validates value is required', function () {
    Livewire::test(PlayerPracticeRating::class, [
        'player' => $this->player,
        'practice' => $this->practice,
    ])
        ->set('value', null)
        ->call('save')
        ->assertHasErrors(['value' => 'required']);
});

it('validates value is numeric', function () {
    Livewire::test(PlayerPracticeRating::class, [
        'player' => $this->player,
        'practice' => $this->practice,
    ])
        ->set('value', 'not-a-number')
        ->call('save')
        ->assertHasErrors(['value' => 'numeric']);
});

it('validates value minimum is 1', function () {
    Livewire::test(PlayerPracticeRating::class, [
        'player' => $this->player,
        'practice' => $this->practice,
    ])
        ->set('value', 0)
        ->call('save')
        ->assertHasErrors(['value' => 'min']);
});

it('validates value maximum is 10', function () {
    Livewire::test(PlayerPracticeRating::class, [
        'player' => $this->player,
        'practice' => $this->practice,
    ])
        ->set('value', 11)
        ->call('save')
        ->assertHasErrors(['value' => 'max']);
});
