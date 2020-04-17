<?php /** @var App\Post $post */ ?>

@props(['post'])

<div class="max-w-6xl w-full bg-white border border-gray-400 md:rounded-lg mx-auto mb-4 last:mb-0">
    <div class="border-b border-gray-400 px-4 py-2">
        <h1 class="text-black text-2xl font-bold">
            <a
                class="hocus:text-blue-700 focus:shadow-outline focus:outline-none transform duration-100"
                href="{{ route('blog.post', $post->slug) }}"
            >
                {{ $post->title }}
            </a>
        </h1>

        <x-blog.post.info :post="$post" />
    </div>

    <div class="markdown p-4">
        @markdown($post, true)...
        <a href="{{ route('blog.post', $post->slug) }}" class="font-semibold whitespace-no-wrap">
            Continue Reading
        </a>
    </div>
</div>
