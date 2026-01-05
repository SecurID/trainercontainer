<?php

namespace Tests\Feature;

use App\Models\Opponent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OpponentTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_displays_opponents()
    {
        Opponent::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('opponents.index'));

        $response->assertStatus(200);
        $response->assertViewIs('opponents.opponents');
        $response->assertViewHas('opponents', function ($opponents) {
            return $opponents->count() === 3;
        });
    }

    public function test_create_displays_opponent_creation_form()
    {
        $response = $this->actingAs($this->user)->get(route('opponents.create'));

        $response->assertStatus(200);
        $response->assertViewIs('opponents.create-opponent');
    }

    public function test_store_creates_new_opponent()
    {
        $opponentData = [
            'name' => 'Test Opponent',
            'notes' => 'Test notes',
        ];

        $response = $this->actingAs($this->user)->post(route('opponents.store'), $opponentData);

        $response->assertRedirect(route('opponents.index'));
        $response->assertSessionHas('success-message');

        $this->assertDatabaseHas('opponents', [
            'name' => 'Test Opponent',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_show_displays_opponent_details()
    {
        $opponent = Opponent::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('opponents.show', $opponent));

        $response->assertStatus(200);
        $response->assertViewIs('opponents.opponent-single');
        $response->assertViewHas('opponent', $opponent);
    }

    public function test_edit_displays_opponent_edit_form()
    {
        $opponent = Opponent::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('opponents.edit', $opponent));

        $response->assertStatus(200);
        $response->assertViewIs('opponents.edit-opponent');
        $response->assertViewHas('opponent', $opponent);
    }

    public function test_update_modifies_opponent()
    {
        $opponent = Opponent::factory()->create(['user_id' => $this->user->id]);

        $updateData = [
            'name' => 'Updated Opponent',
            'notes' => 'Updated notes',
        ];

        $response = $this->actingAs($this->user)->put(route('opponents.update', $opponent), $updateData);

        $response->assertRedirect(route('opponents.index'));
        $response->assertSessionHas('success-message');

        $this->assertDatabaseHas('opponents', [
            'id' => $opponent->id,
            'name' => 'Updated Opponent',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_destroy_deletes_opponent()
    {
        $opponent = Opponent::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->delete(route('opponents.destroy', $opponent));

        $response->assertRedirect(route('opponents.index'));
        $response->assertSessionHas('success-message');

        $this->assertDatabaseMissing('opponents', [
            'id' => $opponent->id,
        ]);
    }

    public function test_user_can_only_see_their_own_opponents()
    {
        $otherUser = User::factory()->create();
        $otherUserOpponent = Opponent::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->get(route('opponents.show', $otherUserOpponent));

        $response->assertStatus(403);
    }

    public function test_store_requires_name()
    {
        $response = $this->actingAs($this->user)->post(route('opponents.store'), [
            'notes' => 'Test notes',
        ]);

        $response->assertSessionHasErrors('name');
    }
}
