<?php

namespace Tests\Feature;

use App\Livewire\DeletePlayer;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PlayerDeletionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_livewire_component_soft_deletes_player(): void
    {
        $player = Player::factory()->for($this->user)->create();

        $this->actingAs($this->user);

        Livewire::test(DeletePlayer::class, ['player' => $player])
            ->call('deletePlayer')
            ->assertRedirect(route('players.index'))
            ->assertSessionHas('success-message', __('Player successfully deleted!'));

        $this->assertSoftDeleted('players', ['id' => $player->id]);
    }

    public function test_user_cannot_delete_another_users_player(): void
    {
        $otherUser = User::factory()->create();
        $otherPlayer = Player::factory()->for($otherUser)->create();

        $this->actingAs($this->user);

        Livewire::test(DeletePlayer::class, ['player' => $otherPlayer])
            ->call('deletePlayer')
            ->assertForbidden();
        $this->assertDatabaseHas('players', ['id' => $otherPlayer->id, 'deleted_at' => null]);
    }

    public function test_index_excludes_soft_deleted_players(): void
    {
        $activePlayer = Player::factory()->for($this->user)->create(['lastname' => 'Active']);
        $deletedPlayer = Player::factory()->for($this->user)->create(['lastname' => 'Deleted']);
        $deletedPlayer->delete();

        $response = $this->actingAs($this->user)->get(route('players.index'));

        $response->assertStatus(200);
        $response->assertViewHas('players', function ($players) use ($activePlayer) {
            return $players->contains('id', $activePlayer->id)
                && $players->whereNotNull('deleted_at')->isEmpty();
        });
    }
}
