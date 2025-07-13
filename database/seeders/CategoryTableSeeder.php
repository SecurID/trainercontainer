<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'warmup'],
            ['name' => 'games'],
            ['name' => 'individual'],
            ['name' => 'technical'],
            ['name' => 'tactical'],
            ['name' => '1-on-1'],
            ['name' => 'over-under-forms'],
            ['name' => 'passing'],
            ['name' => 'shooting'],
            ['name' => 'dribbling'],
            ['name' => 'cognition'],
            ['name' => 'coordination'],
            ['name' => 'speed'],
            ['name' => 'endurance'],
        ];

        Category::insert($categories);
    }
}
