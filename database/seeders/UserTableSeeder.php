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
    public function run()
    {
        $user = new User();
        $user->name = "Yannick";
        $user->email = "yannick.kupferschmidt@googlemail.com";
        $user->password = '$2y$10$TCAu.D7qxs7/D1FkPwNvb.Depwm7hcdU.wr512bYulbTFpZ0A9awi';
        $user->save();
    }
}
