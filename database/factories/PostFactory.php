<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /** @var string */
    protected $model = Post::class;

    public function definition(): array
    {
        $title = ucwords($this->faker->sentence);

        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'content' => $this->faker->paragraphs(6, true),
            'published_at' => $this->faker->dateTimeThisMonth,
        ];
    }

    public function withAuthor(User $author): self
    {
        return $this->state([
            'author_id' => $author->id,
        ]);
    }
}
