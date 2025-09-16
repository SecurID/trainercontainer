<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Practice;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PlayerChartOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_chart_orders_labels_chronologically()
    {
        $user = User::factory()->create();
        $player = Player::factory()->for($user)->create();

        $earlierPractice = Practice::factory()->create([
            'user_id' => $user->id,
            'date' => Carbon::parse('2024-04-30'),
        ]);

        $laterPractice = Practice::factory()->create([
            'user_id' => $user->id,
            'date' => Carbon::parse('2024-05-02'),
        ]);

        Rating::factory()->create([
            'user_id' => $user->id,
            'player_id' => $player->id,
            'practice_id' => $laterPractice->id,
            'rating' => 4,
        ]);

        Rating::factory()->create([
            'user_id' => $user->id,
            'player_id' => $player->id,
            'practice_id' => $earlierPractice->id,
            'rating' => 2,
        ]);

        $response = $this->actingAs($user)->get(route('players.show', $player));

        $response->assertStatus(200);
        $response->assertViewHas('labels', function ($labels) {
            return $labels === ['30.04.2024', '02.05.2024'];
        });
        $response->assertViewHas('ratings_array', function ($ratings) {
            return $ratings === [2, 4];
        });
    }
}
