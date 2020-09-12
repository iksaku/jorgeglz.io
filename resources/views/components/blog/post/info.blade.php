<?php /** @var App\Models\Post $post */ ?>

@props(['post', 'link' => true])

<div class="px-4 py-2 space-y-2">
    <h1 class="text-2xl font-bold">
        @if($link)
            <a
                class="hocus:text-blue-500 focus:shadow-outline focus:outline-none"
                href="{{ route('blog.post', $post) }}"
            >
                {{ $post->title }}
            </a>
        @else
            {{ $post->title }}
        @endif
    </h1>

    <div class="flex items-center text-gray-800 dark:text-gray-300 text-sm md:text-base font-medium space-x-1">
        <span>
            {{--{{ emoji('date') }}--}}
            📅
        </span>

        <time datetime="{{ $post->published_at->toISOString() }}">
            {{ $post->published_at->format('F j, Y') }}
        </time>
    </div>
</div>
