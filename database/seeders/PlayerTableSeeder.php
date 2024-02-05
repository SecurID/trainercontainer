<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;

class PlayerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $players = [
            ['prename' => 'Player1', 'lastname' => 'Player1', 'notes' => 'Lazy in training', 'user_id' => 1],
            ['prename' => 'Player2', 'lastname' => 'Player2', 'notes' => 'Captain', 'user_id' => 1],
            ['prename' => 'Player3', 'lastname' => 'Player3', 'notes' => 'Dribbler', 'user_id' => 1],
            ['prename' => 'Player4', 'lastname' => 'Player4', 'notes' => 'Passer', 'user_id' => 1],
            ['prename' => 'Player5', 'lastname' => 'Player5', 'notes' => 'Diametral six', 'user_id' => 1],
            ['prename' => 'Player6', 'lastname' => 'Player6', 'notes' => 'Striker', 'user_id' => 1],
            ['prename' => 'Player7', 'lastname' => 'Player7', 'notes' => 'Worst player ever', 'user_id' => 1],
        ];

        Player::insert($players);
    }
}
