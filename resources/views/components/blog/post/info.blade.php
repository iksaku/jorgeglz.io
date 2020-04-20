<?php /** @var App\Post $post */ ?>

@props(['post'])

<div class="w-full flex items-center text-gray-800 dark:text-gray-300 text-sm font-medium px-1">
    <a
        class="flex items-center hocus:text-blue-500 focus:shadow-outline focus:outline-none mr-4 transform duration-100"
        href="{{ route('blog.about') }}"
    >
        <img
            class="hidden sm:block h-6 w-6 rounded-full overflow-hidden mr-1"
            src="{{ $post->author->avatar }}"
            alt="Avatar of {{ $post->author->name }}"
        />

        <div>
            {{ $post->author->name }}
        </div>
    </a>

    <div class="flex items-center">
        <span class="emoji mr-1">
            {{ emoji('date') }}
        </span>

        @if($post->published())
            <time datetime="{{ $post->published_at->toISOString() }}">
                {{ $post->published_at->format('F j, Y') }}
            </time>
        @else
            <span class="text-red-500 italic font-bold">
                Draft
            </span>
        @endif
    </div>
</div>
