<?php

namespace Database\Seeders;

use App\Models\Practice;
use Illuminate\Database\Seeder;

class PracticeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $userIds = \App\Models\User::pluck('id')->toArray();
        \App\Models\Practice::factory(10)->make()->each(function ($practice) use ($userIds) {
            $practice->user_id = fake()->randomElement($userIds);
            $practice->save();
        });
    }
}
