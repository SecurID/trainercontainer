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
    public function run(): void
    {
        $userIds = \App\Models\User::pluck('id')->toArray();
        \App\Models\Exercise::factory(25)->make()->each(function ($exercise) use ($userIds) {
            $exercise->user_id = fake()->randomElement($userIds);
            $exercise->save();
        });
    }
}
