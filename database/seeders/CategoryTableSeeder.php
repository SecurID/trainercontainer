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
    public function run()
    {
        $categories = [
            ['name' => 'Warm-up'],
            ['name' => 'Games'],
            ['name' => 'Individual training'],
            ['name' => 'Technical training'],
            ['name' => 'Tactical training'],
            ['name' => '1 on 1'],
            ['name' => 'Over-under forms']
        ];

        Category::insert($categories);
    }
}
