<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Admin-User
        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@test.com',
            'is_admin' => 1,
            'password' => bcrypt('password'),
        ]);
        // Weitere zufällige User
        User::factory(10)->create();
    }
}
