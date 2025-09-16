<?php

namespace Tests\Feature;

use App\Models\Practice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_prioritizes_today_practice()
    {
        Carbon::setTestNow(Carbon::parse('2024-05-01 15:00:00'));

        $user = User::factory()->create();

        Practice::factory()->create([
            'user_id' => $user->id,
            'date' => Carbon::parse('2024-04-30'),
            'time' => '18:00',
        ]);

        $todayPractice = Practice::factory()->create([
            'user_id' => $user->id,
            'date' => Carbon::parse('2024-05-01'),
            'time' => '09:00',
        ]);

        Practice::factory()->create([
            'user_id' => $user->id,
            'date' => Carbon::parse('2024-05-02'),
            'time' => '10:00',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('nextPractice', function ($practice) use ($todayPractice) {
            return $practice->is($todayPractice);
        });

        Carbon::setTestNow();
    }
}

