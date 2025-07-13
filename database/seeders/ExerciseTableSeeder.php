<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Exercise;
use App\Models\User;
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
        $userIds = User::pluck('id')->toArray();
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run CategoryTableSeeder first.');
            return;
        }
        
        Exercise::factory(25)->make()->each(function ($exercise) use ($userIds, $categories) {
            $exercise->user_id = fake()->randomElement($userIds);
            $exercise->save();
            
            // Attach 1-3 random categories to each exercise
            $randomCategories = $categories->random(rand(1, 3));
            $exercise->categories()->attach($randomCategories->pluck('id'));
        });
    }
}
