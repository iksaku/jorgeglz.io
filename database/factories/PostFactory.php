<?php

/** @var Factory $factory */
use App\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'slug' => Str::slug($title = ucwords($faker->sentence)),
        'title' => $title,
        'description' => $faker->sentences(3, true),
        'content' => $faker->paragraphs(6, true),
        'published_at' => $faker->dateTimeThisMonth,
    ];
});
