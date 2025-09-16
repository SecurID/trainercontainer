<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTableSeeder::class,
            CategoryTableSeeder::class,
            PositionSeeder::class,
        ]);
        if (config('app.env') == 'local') {
            $this->call([
                ExerciseTableSeeder::class,
                // ExerciseCategorySeeder::class,
                PracticeTableSeeder::class,
                PlayerTableSeeder::class,
                RatingTableSeeder::class,
            ]);
        }
    }
}
