<?php /** @var App\Post $post */ ?>

@props(['post', 'link' => true])

<div class="border-b border-gray-400 dark:border-gray-600 px-4 py-2 space-y-2">
    <h1 class="text-2xl font-bold">
        @if($link)
            <a
                class="hocus:text-blue-500 focus:shadow-outline focus:outline-none"
                href="{{ route('blog.post', $post->slug) }}"
            >
                {{ $post->title }}
            </a>
        @else
            {{ $post->title }}
        @endif
    </h1>

    <div class="flex items-center text-gray-800 dark:text-gray-300 text-sm md:text-base font-medium space-x-8">
        <a
            class="flex items-center hocus:text-blue-500 focus:shadow-outline focus:outline-none space-x-1"
            href="{{ route('blog.about') }}"
        >
            <img
                class="h-8 w-8 rounded-full"
                src="{{ $post->author->avatar }}"
                alt="{{ $post->author->name }}'s Avatar"
            />

            <div>
                {{ $post->author->name }}
            </div>
        </a>

        <div class="flex items-center space-x-1">
        <span class="font-emoji">
            {{ emoji('date') }}
        </span>

            <time datetime="{{ $post->published_at->toISOString() }}">
                {{ $post->published_at->format('F j, Y') }}
            </time>
        </div>
    </div>
</div>
