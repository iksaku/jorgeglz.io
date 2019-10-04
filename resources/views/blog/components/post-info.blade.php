<?php /** @var App\Post $post */ ?>

<div class="text-gray-800 text-sm px-1">
    <div class="inline-block">
        <div class="py-1">
            <span class="hidden sm:inline-block align-middle">
                <img
                    class="h-6 w-6 rounded-full overflow-hidden mr-1"
                    src="{{ $post->author->avatar }}"
                    alt="Avatar of {{ $post->author->name }}"
                />
            </span>
            <span class="text-gray-800 inline-block align-middle">
                {{ $post->author->name }}
            </span>
        </div>
    </div>

    <span class="mx-1 inline-block">&vert;</span>

    <div class="inline-block">
        <span
            class="text-center font-sans inline-block align-middle mr-1"
        >
            {!! github_emoji('date') !!}
        </span>
        <span class="inline-block align-middle">
            @if($post->published)
                <time datetime="{{ $post->published_at->toISOString() }}">
                    {{ $post->published_at->format('F j, Y') }}
                </time>
            @else
                <span class="text-red-700 italic font-bold" v-else>
                    Draft
                </span>
            @endif
        </span>
    </div>
</div>
