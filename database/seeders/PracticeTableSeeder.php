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
    public function run()
    {
        $practice = new Practice();
        $practice->date = date('Y-m-d');
        $practice->user_id = 1;
        $practice->save();
    }
}
