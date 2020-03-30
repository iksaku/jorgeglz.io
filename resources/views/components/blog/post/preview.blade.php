<?php /** @var App\Post $post */ ?>

<div class="max-w-6xl w-full post-preview bg-gray-100 border border-gray-400 rounded shadow mx-auto">
    <div class="border-b-2 border-gray-300 rounded p-4 pb-2">
        <a href="{{ route('blog.post', $post->slug) }}" class="text-black inline-block">
            <h1 class="text-2xl font-bold">
                {{ $post->title }}
            </h1>
        </a>

        <x-blog.post.info :post="$post" />
    </div>
    <div class="markdown text-justify p-4">
        @markdown($post, true)...
        <a href="{{ route('blog.post', $post->slug) }}" class="font-bold whitespace-no-wrap">
            Continue Reading
        </a>
    </div>
</div>
