<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::whereEmail('iksaku@me.com')
            ->select(['id'])
            ->first();

        Post::factory()->count(50)->withAuthor($user)->create();
    }
}
