<?php

namespace Database\Seeders;

use App\Models\Rating;
use Faker\Provider\Base;
use Faker\Provider\DateTime;
use Illuminate\Database\Seeder;

class RatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 100; $i++){
            $rating = new Rating();
            $rating->date = DateTime::dateTimeThisMonth()->format('Y-m-d');
            $rating->player_id = Base::numberBetween(1,7);
            $rating->user_id = 1;
            $rating->rating = Base::numberBetween(1,5);
            $rating->save();
        }
    }
}
