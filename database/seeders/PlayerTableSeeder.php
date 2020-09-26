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
            ['prename' => 'Nuno', 'name' => 'Mützel', 'notes' => 'Trainingsfaul'],
            ['prename' => 'Esad', 'name' => 'Akgün', 'notes' => 'Captain'],
            ['prename' => 'Leonard-Anton', 'name' => 'Riedel', 'notes' => 'Trainingsmeister'],
            ['prename' => 'Janis', 'name' => 'Brater', 'notes' => 'Maschine'],
            ['prename' => 'Valentin', 'name' => 'Rödl', 'notes' => 'Spielintelligent'],
            ['prename' => 'Julian', 'name' => 'Pabst', 'notes' => 'Ruhiger Star'],
            ['prename' => 'Leon', 'name' => 'Wohlfart', 'notes' => 'lul'],
        ];

        Player::insert($players);
    }
}
