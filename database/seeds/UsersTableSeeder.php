<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'iksaku@me.com',
        ], [
            'name' => 'Jorge González',
            'password' => bcrypt('123456'),
        ]);
    }
}
