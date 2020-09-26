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
            ['prename' => 'Nuno', 'name' => 'Mützel', 'notes' => 'Trainingsfaul', 'user_id' => 1],
            ['prename' => 'Esad', 'name' => 'Akgün', 'notes' => 'Captain', 'user_id' => 1],
            ['prename' => 'Leonard-Anton', 'name' => 'Riedel', 'notes' => 'Trainingsmeister', 'user_id' => 1],
            ['prename' => 'Janis', 'name' => 'Brater', 'notes' => 'Maschine', 'user_id' => 1],
            ['prename' => 'Valentin', 'name' => 'Rödl', 'notes' => 'Spielintelligent', 'user_id' => 1],
            ['prename' => 'Julian', 'name' => 'Pabst', 'notes' => 'Ruhiger Star', 'user_id' => 1],
            ['prename' => 'Leon', 'name' => 'Wohlfart', 'notes' => 'lul', 'user_id' => 1],
        ];

        Player::insert($players);
    }
}
