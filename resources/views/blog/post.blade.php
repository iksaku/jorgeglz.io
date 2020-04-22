<?php /** @var App\Post $post */ ?>

@extends('blog.partials.template')

@section('title', $post->title)

<x-use.highlight />

@section('content')
    <div class="max-w-6xl w-full bg-gray-100 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg mx-auto">
        <div class="border-b border-gray-400 dark:border-gray-600 px-4 py-2">
            <h1 class="text-2xl font-bold">
                {{ $post->title }}
            </h1>

            <x-blog.post.info :post="$post" />
        </div>

        <article class="markdown p-4">
            @markdown($post)
        </article>
    </div>
@endsection
