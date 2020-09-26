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
            ['name' => 'Aufwärmen'],
            ['name' => 'Spielformen'],
            ['name' => 'Individualtraining'],
            ['name' => 'Techniktraining'],
            ['name' => 'Taktiktraining'],
            ['name' => '1 gegen 1'],
            ['name' => 'Über-Unterzahl-Formen']
        ];

        Category::insert($categories);
    }
}
