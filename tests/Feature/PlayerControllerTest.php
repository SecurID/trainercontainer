<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Position;
use App\Models\Practice;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('displays players index', function () {
    Player::factory()->count(3)->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->get(route('players.index'));

    $response->assertStatus(200);
    $response->assertViewIs('players.players');
    $response->assertViewHas('players', fn ($players) => $players->count() === 3);
});

it('only shows players for authenticated user', function () {
    $otherUser = User::factory()->create();
    Player::factory()->count(2)->create(['user_id' => $this->user->id]);
    Player::factory()->count(3)->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($this->user)->get(route('players.index'));

    $response->assertViewHas('players', fn ($players) => $players->count() === 2);
});

it('orders players by lastname', function () {
    Player::factory()->create(['user_id' => $this->user->id, 'lastname' => 'Zimmermann']);
    Player::factory()->create(['user_id' => $this->user->id, 'lastname' => 'Abel']);
    Player::factory()->create(['user_id' => $this->user->id, 'lastname' => 'Mueller']);

    $response = $this->actingAs($this->user)->get(route('players.index'));

    $players = $response->viewData('players');
    expect($players->first()->lastname)->toBe('Abel');
    expect($players->last()->lastname)->toBe('Zimmermann');
});

it('displays create player form', function () {
    $response = $this->actingAs($this->user)->get(route('players.create'));

    $response->assertStatus(200);
    $response->assertViewIs('players.create-player');
});

it('displays player details', function () {
    $player = Player::factory()->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->get(route('players.show', $player));

    $response->assertStatus(200);
    $response->assertViewIs('players.player-single');
    $response->assertViewHas('player');
    $response->assertViewHas('ratings');
    $response->assertViewHas('labels');
    $response->assertViewHas('ratings_array');
});

it('denies access to other users player', function () {
    $otherUser = User::factory()->create();
    $player = Player::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($this->user)->get(route('players.show', $player));

    $response->assertForbidden();
});

it('loads player with positions on show', function () {
    $mainPosition = Position::factory()->create();
    $subPositions = Position::factory()->count(2)->create();
    $player = Player::factory()->create([
        'user_id' => $this->user->id,
        'main_position_id' => $mainPosition->id,
    ]);
    $player->subPositions()->attach($subPositions->pluck('id'));

    $response = $this->actingAs($this->user)->get(route('players.show', $player));

    $response->assertStatus(200);
    $viewPlayer = $response->viewData('player');
    expect($viewPlayer->mainPosition)->not->toBeNull();
    expect($viewPlayer->subPositions)->toHaveCount(2);
});

it('loads ratings with practice on show', function () {
    $player = Player::factory()->create(['user_id' => $this->user->id]);
    $practice = Practice::factory()->create(['user_id' => $this->user->id]);
    Rating::factory()->create([
        'player_id' => $player->id,
        'practice_id' => $practice->id,
        'user_id' => $this->user->id,
        'rating' => 8,
    ]);

    $response = $this->actingAs($this->user)->get(route('players.show', $player));

    $response->assertStatus(200);
    $ratings = $response->viewData('ratings');
    expect($ratings)->toHaveCount(1);
});

it('loads ratings with game on show', function () {
    $player = Player::factory()->create(['user_id' => $this->user->id]);
    $game = Game::factory()->create(['user_id' => $this->user->id]);
    Rating::factory()->create([
        'player_id' => $player->id,
        'game_id' => $game->id,
        'user_id' => $this->user->id,
        'rating' => 9,
    ]);

    $response = $this->actingAs($this->user)->get(route('players.show', $player));

    $response->assertStatus(200);
    $ratings = $response->viewData('ratings');
    expect($ratings)->toHaveCount(1);
});

it('sorts ratings by date', function () {
    $player = Player::factory()->create(['user_id' => $this->user->id]);
    $oldPractice = Practice::factory()->create([
        'user_id' => $this->user->id,
        'date' => now()->subDays(10),
    ]);
    $newPractice = Practice::factory()->create([
        'user_id' => $this->user->id,
        'date' => now(),
    ]);
    Rating::factory()->create([
        'player_id' => $player->id,
        'practice_id' => $newPractice->id,
        'user_id' => $this->user->id,
        'rating' => 9,
    ]);
    Rating::factory()->create([
        'player_id' => $player->id,
        'practice_id' => $oldPractice->id,
        'user_id' => $this->user->id,
        'rating' => 7,
    ]);

    $response = $this->actingAs($this->user)->get(route('players.show', $player));

    $ratings = $response->viewData('ratings');
    expect($ratings->first()->rating)->toBe(7);
    expect($ratings->last()->rating)->toBe(9);
});

it('formats labels as dates', function () {
    $player = Player::factory()->create(['user_id' => $this->user->id]);
    $practice = Practice::factory()->create([
        'user_id' => $this->user->id,
        'date' => now()->startOfDay(),
    ]);
    Rating::factory()->create([
        'player_id' => $player->id,
        'practice_id' => $practice->id,
        'user_id' => $this->user->id,
        'rating' => 8,
    ]);

    $response = $this->actingAs($this->user)->get(route('players.show', $player));

    $labels = $response->viewData('labels');
    expect($labels[0])->toBe(now()->format('d.m.Y'));
});

it('extracts ratings array', function () {
    $player = Player::factory()->create(['user_id' => $this->user->id]);
    $practice = Practice::factory()->create(['user_id' => $this->user->id]);
    Rating::factory()->create([
        'player_id' => $player->id,
        'practice_id' => $practice->id,
        'user_id' => $this->user->id,
        'rating' => 8,
    ]);

    $response = $this->actingAs($this->user)->get(route('players.show', $player));

    $ratingsArray = $response->viewData('ratings_array');
    expect($ratingsArray)->toBe([8]);
});

it('displays position analysis page', function () {
    Position::factory()->count(3)->create();

    $response = $this->actingAs($this->user)->get(route('players.position-analysis'));

    $response->assertStatus(200);
    $response->assertViewIs('players.position-analysis');
    $response->assertViewHas('positionAnalysis');
    $response->assertViewHas('totalPlayers');
});

it('calculates main position counts', function () {
    $position = Position::factory()->create();
    Player::factory()->count(2)->create([
        'user_id' => $this->user->id,
        'main_position_id' => $position->id,
    ]);

    $response = $this->actingAs($this->user)->get(route('players.position-analysis'));

    $analysis = collect($response->viewData('positionAnalysis'));
    $positionData = $analysis->firstWhere('position.id', $position->id);
    expect($positionData['main_count'])->toBe(2);
});

it('calculates sub position counts', function () {
    $position = Position::factory()->create();
    $players = Player::factory()->count(2)->create(['user_id' => $this->user->id]);
    foreach ($players as $player) {
        $player->subPositions()->attach($position->id);
    }

    $response = $this->actingAs($this->user)->get(route('players.position-analysis'));

    $analysis = collect($response->viewData('positionAnalysis'));
    $positionData = $analysis->firstWhere('position.id', $position->id);
    expect($positionData['sub_count'])->toBe(2);
});

it('calculates total coverage', function () {
    $position = Position::factory()->create();
    Player::factory()->create([
        'user_id' => $this->user->id,
        'main_position_id' => $position->id,
    ]);
    $player = Player::factory()->create(['user_id' => $this->user->id]);
    $player->subPositions()->attach($position->id);

    $response = $this->actingAs($this->user)->get(route('players.position-analysis'));

    $analysis = collect($response->viewData('positionAnalysis'));
    $positionData = $analysis->firstWhere('position.id', $position->id);
    expect($positionData['total_count'])->toBe(2);
});

it('returns critical status for zero coverage', function () {
    Position::factory()->create();

    $response = $this->actingAs($this->user)->get(route('players.position-analysis'));

    $analysis = $response->viewData('positionAnalysis');
    expect($analysis[0]['coverage_status'])->toBe('critical');
});

it('returns low status for one player coverage', function () {
    $position = Position::factory()->create();
    Player::factory()->create([
        'user_id' => $this->user->id,
        'main_position_id' => $position->id,
    ]);

    $response = $this->actingAs($this->user)->get(route('players.position-analysis'));

    $analysis = collect($response->viewData('positionAnalysis'));
    $positionData = $analysis->firstWhere('position.id', $position->id);
    expect($positionData['coverage_status'])->toBe('low');
});

it('returns medium status for two to three players coverage', function () {
    $position = Position::factory()->create();
    Player::factory()->count(3)->create([
        'user_id' => $this->user->id,
        'main_position_id' => $position->id,
    ]);

    $response = $this->actingAs($this->user)->get(route('players.position-analysis'));

    $analysis = collect($response->viewData('positionAnalysis'));
    $positionData = $analysis->firstWhere('position.id', $position->id);
    expect($positionData['coverage_status'])->toBe('medium');
});

it('returns good status for more than three players coverage', function () {
    $position = Position::factory()->create();
    Player::factory()->count(4)->create([
        'user_id' => $this->user->id,
        'main_position_id' => $position->id,
    ]);

    $response = $this->actingAs($this->user)->get(route('players.position-analysis'));

    $analysis = collect($response->viewData('positionAnalysis'));
    $positionData = $analysis->firstWhere('position.id', $position->id);
    expect($positionData['coverage_status'])->toBe('good');
});

it('sorts positions by coverage ascending', function () {
    $lowPosition = Position::factory()->create(['name' => 'Low Coverage']);
    $highPosition = Position::factory()->create(['name' => 'High Coverage']);

    Player::factory()->count(5)->create([
        'user_id' => $this->user->id,
        'main_position_id' => $highPosition->id,
    ]);
    Player::factory()->create([
        'user_id' => $this->user->id,
        'main_position_id' => $lowPosition->id,
    ]);

    $response = $this->actingAs($this->user)->get(route('players.position-analysis'));

    $analysis = $response->viewData('positionAnalysis');
    expect($analysis[0]['position']->id)->toBe($lowPosition->id);
    expect($analysis[1]['position']->id)->toBe($highPosition->id);
});

it('counts total players correctly', function () {
    Position::factory()->create();
    Player::factory()->count(5)->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->get(route('players.position-analysis'));

    expect($response->viewData('totalPlayers'))->toBe(5);
});

it('only counts players for authenticated user', function () {
    $otherUser = User::factory()->create();
    Position::factory()->create();
    Player::factory()->count(3)->create(['user_id' => $this->user->id]);
    Player::factory()->count(5)->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($this->user)->get(route('players.position-analysis'));

    expect($response->viewData('totalPlayers'))->toBe(3);
});
