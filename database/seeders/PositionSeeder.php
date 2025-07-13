<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['name' => 'Goalkeeper', 'abbreviation' => 'GK', 'description' => 'Goalkeeper who protects the goal'],
            ['name' => 'Center Back', 'abbreviation' => 'CB', 'description' => 'Central defender'],
            ['name' => 'Left Back', 'abbreviation' => 'LB', 'description' => 'Left-sided defender'],
            ['name' => 'Right Back', 'abbreviation' => 'RB', 'description' => 'Right-sided defender'],
            ['name' => 'Left Wing Back', 'abbreviation' => 'LWB', 'description' => 'Left wing back with attacking duties'],
            ['name' => 'Right Wing Back', 'abbreviation' => 'RWB', 'description' => 'Right wing back with attacking duties'],
            ['name' => 'Defensive Midfielder', 'abbreviation' => 'CDM', 'description' => 'Central defensive midfielder'],
            ['name' => 'Central Midfielder', 'abbreviation' => 'CM', 'description' => 'Central midfielder with box-to-box duties'],
            ['name' => 'Attacking Midfielder', 'abbreviation' => 'CAM', 'description' => 'Central attacking midfielder'],
            ['name' => 'Left Midfielder', 'abbreviation' => 'LM', 'description' => 'Left-sided midfielder'],
            ['name' => 'Right Midfielder', 'abbreviation' => 'RM', 'description' => 'Right-sided midfielder'],
            ['name' => 'Left Winger', 'abbreviation' => 'LW', 'description' => 'Left winger with attacking duties'],
            ['name' => 'Right Winger', 'abbreviation' => 'RW', 'description' => 'Right winger with attacking duties'],
            ['name' => 'Striker', 'abbreviation' => 'ST', 'description' => 'Central striker'],
            ['name' => 'Center Forward', 'abbreviation' => 'CF', 'description' => 'Central forward with creative duties'],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
