<?php

namespace Database\Seeders;

use App\Models\Practice;
use App\Models\User;
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
        $userIds = User::pluck('id')->toArray();
        User::all()->each(function ($user) use ($userIds) {
            $user->practices()->saveMany(Practice::factory(10)->make()->each(function ($practice) use ($userIds) {
                $practice->user_id = fake()->randomElement($userIds);
            }));
        });
    }
}
