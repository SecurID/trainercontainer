<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Seeder;

class ExerciseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 25; $i++){
            $exercise = new Exercise();
            $exercise->name = "4 gegen 2 Rondo";
            $exercise->focus = "Ballbesitzspiel";
            $exercise->material = "4 Hütchen";
            $exercise->procedure = '- Vier Hütchen in einem Quadrat markieren. <br> - 4 Spieler positionieren sich außen auf den Linien <br> - Die Spieler im Zentrum versuchen den Ball zu erobern <br> - Bei Ballberührung wird mit den Außen getauscht';
            $exercise->coaching = '- Freie Räume belaufen <br> - Schnelle Entscheidungsfindung <br> - Variables, beidfüßiges Spiel ';
            $exercise->duration = 10;
            $exercise->intensity = 40;
            $exercise->image = "https://i2.wp.com/thefalsefullback.de/wp-content/uploads/2019/02/trainingsform-1.png?ssl=1";
            $exercise->user_id = 1;
            $exercise->save();
        }
    }
}
