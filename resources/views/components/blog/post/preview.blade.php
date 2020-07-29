<?php /** @var App\Post $post */ ?>

@props(['post'])

<div class="bg-gray-100 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg">
    <x-blog.post.info :post="$post" />

    <div class="markdown p-4">
        <p>
            @markdown($post, true)...
            <a href="{{ route('blog.post', $post->slug) }}" class="font-semibold whitespace-no-wrap">
                Continue Reading
            </a>
        </p>
    </div>
</div>
