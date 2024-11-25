<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            "name" => "user_1"
        ], [
            'email' => 'user_1@gmail.com',
            'password' => Hash::make('password'),
        ]);
        User::updateOrCreate([
            "name" => "user_2"
        ], [
            'email' => 'user_2@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
