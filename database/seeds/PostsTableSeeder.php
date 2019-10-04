<?php

use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereEmail('iksaku@me.com')->first();

        factory(Post::class, 50)->make()->each(function (Post $post) use ($user) {
            $user->posts()->save($post);
        });
    }
}
