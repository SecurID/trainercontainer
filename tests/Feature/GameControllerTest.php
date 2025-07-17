<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_displays_games()
    {
        Game::factory()->count(3)->create(['user_id' => $this->user->id]);
        
        $response = $this->actingAs($this->user)->get(route('games.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('games.games');
        $response->assertViewHas('games', function ($games) {
            return $games->count() === 3;
        });
    }

    public function test_create_displays_game_creation_form()
    {
        $response = $this->actingAs($this->user)->get(route('games.create'));
        
        $response->assertStatus(200);
        $response->assertViewIs('games.create-game');
    }

    public function test_store_creates_new_game()
    {
        $gameData = [
            'opponent' => 'Test Opponent',
            'date' => '2024-01-01',
            'time' => '15:00',
            'location' => 'Test Stadium',
            'notes' => 'Test notes'
        ];

        $response = $this->actingAs($this->user)->post(route('games.store'), $gameData);

        $response->assertRedirect(route('games.index'));
        $response->assertSessionHas('success-message');
        
        $this->assertDatabaseHas('games', [
            'opponent' => 'Test Opponent',
            'user_id' => $this->user->id
        ]);
    }

    public function test_show_displays_game_details()
    {
        $game = Game::factory()->create(['user_id' => $this->user->id]);
        
        $response = $this->actingAs($this->user)->get(route('games.show', $game));
        
        $response->assertStatus(200);
        $response->assertViewIs('games.game-single');
        $response->assertViewHas('game', $game);
    }

    public function test_edit_displays_game_edit_form()
    {
        $game = Game::factory()->create(['user_id' => $this->user->id]);
        
        $response = $this->actingAs($this->user)->get(route('games.edit', $game));
        
        $response->assertStatus(200);
        $response->assertViewIs('games.edit-game');
        $response->assertViewHas('game', $game);
    }

    public function test_update_modifies_game()
    {
        $game = Game::factory()->create(['user_id' => $this->user->id]);
        
        $updateData = [
            'opponent' => 'Updated Opponent',
            'date' => '2024-02-01',
            'time' => '16:00',
            'location' => 'Updated Stadium',
            'notes' => 'Updated notes'
        ];

        $response = $this->actingAs($this->user)->put(route('games.update', $game), $updateData);

        $response->assertRedirect(route('games.index'));
        $response->assertSessionHas('success-message');
        
        $this->assertDatabaseHas('games', [
            'id' => $game->id,
            'opponent' => 'Updated Opponent',
            'user_id' => $this->user->id
        ]);
    }

    public function test_destroy_deletes_game()
    {
        $game = Game::factory()->create(['user_id' => $this->user->id]);
        
        $response = $this->actingAs($this->user)->delete(route('games.destroy', $game));

        $response->assertRedirect(route('games.index'));
        $response->assertSessionHas('success-message');
        
        $this->assertDatabaseMissing('games', [
            'id' => $game->id
        ]);
    }

    public function test_user_can_only_see_their_own_games()
    {
        $otherUser = User::factory()->create();
        $otherUserGame = Game::factory()->create(['user_id' => $otherUser->id]);
        
        $response = $this->actingAs($this->user)->get(route('games.show', $otherUserGame));
        
        $response->assertStatus(403);
    }
}