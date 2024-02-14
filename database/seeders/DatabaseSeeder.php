<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Exercise;
use App\Models\Practice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UserTableSeeder::class,
            CategoryTableSeeder::class,
        ]);
        if (env('APP_ENV') == 'local') {
            $this->call([
                ExerciseTableSeeder::class,
                PracticeTableSeeder::class,
                PlayerTableSeeder::class,
                RatingTableSeeder::class,
            ]);
        }
    }
}
