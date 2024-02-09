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
            $exercise->name = "4 vs. 2 rondo";
            $exercise->focus = "Possesion";
            $exercise->material = "4 cones";
            $exercise->procedure = 'Example procedure';
            $exercise->coaching = 'Example coaching';
            $exercise->duration = 10;
            $exercise->intensity = 40;
            $exercise->image = "https://fussballtraining24.de/wp-content/uploads/2021/04/fussballuebung-2.jpg";
            $exercise->user_id = 1;
            $exercise->save();
        }

        //associate each practice with one or more categories from 1-7
        for($i = 0; $i < 25; $i++){
            $exercise = Exercise::find($i + 1);
            $exercise->categories()->attach(rand(1,7));
            $exercise->save();
            $exercise->categories()->attach(rand(1,7));
            $exercise->save();
        }
    }
}
