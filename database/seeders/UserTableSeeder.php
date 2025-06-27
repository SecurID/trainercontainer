<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = new User();
        $user->name = "Test";
        $user->email = "test@test.com";
        $user->password = Hash::make('password');
        $user->is_admin = 1;
        $user->save();
    }
}
