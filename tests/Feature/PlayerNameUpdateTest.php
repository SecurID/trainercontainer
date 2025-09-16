<?php

namespace Tests\Feature;

use App\Livewire\EditPlayerName;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PlayerNameUpdateTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_livewire_component_updates_player_name(): void
    {
        $player = Player::factory()->for($this->user)->create([
            'prename' => 'Initial',
            'lastname' => 'Name',
        ]);

        $this->actingAs($this->user);

        Livewire::test(EditPlayerName::class, ['player' => $player])
            ->set('prename', 'Updated')
            ->set('lastname', 'Player')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('players.show', $player))
            ->assertSessionHas('success-message', __('Player name updated!'));

        $this->assertDatabaseHas('players', [
            'id' => $player->id,
            'prename' => 'Updated',
            'lastname' => 'Player',
        ]);
    }

    public function test_user_cannot_update_another_users_player(): void
    {
        $otherUser = User::factory()->create();
        $player = Player::factory()->for($otherUser)->create();

        $this->actingAs($this->user);

        Livewire::test(EditPlayerName::class, ['player' => $player])
            ->set('prename', 'Invalid')
            ->set('lastname', 'Update')
            ->call('save')
            ->assertForbidden();

        $this->assertDatabaseHas('players', [
            'id' => $player->id,
            'prename' => $player->prename,
            'lastname' => $player->lastname,
        ]);
    }

    public function test_validation_errors_are_returned(): void
    {
        $player = Player::factory()->for($this->user)->create();

        $this->actingAs($this->user);

        Livewire::test(EditPlayerName::class, ['player' => $player])
            ->set('prename', '')
            ->set('lastname', '')
            ->call('save')
            ->assertHasErrors(['prename' => 'required', 'lastname' => 'required']);
    }
}
