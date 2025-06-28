<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Player::all()->each(function ($player) {
            for ($i = 0; $i < 10; $i++) {
                $rating = Rating::factory()->make();
                $rating->player_id = $player->id;
                $rating->save();
            }
        });
    }
}
