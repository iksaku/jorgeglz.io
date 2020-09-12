<?php /* @var App\Models\Post $post */ ?>

<x-meta og="title" content="JorgeGlz Blog" />
<x-meta og="description" content="Hello! I have a blog! And here you can find... Well... Blog posts..." />

@if($this->posts->isNotEmpty())
    <div class="w-full mx-auto space-y-4">
        @foreach ($this->posts as $post)
            <div class="w-full bg-gray-100 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg">
                <x-blog.post.info :post="$post" />

                {{--<div class="markdown p-4">
                    <p>
                        @markdown($post, true)...
                        <a href="{{ route('blog.post', $post->slug) }}" class="font-semibold whitespace-no-wrap">
                            Continue Reading
                        </a>
                    </p>
                </div>--}}
            </div>
        @endforeach

        {{ $this->posts->links() }}
    </div>
@else
    <div class="w-full self-center text-center text-2xl italic font-light">
        No posts available right now.
    </div>
@endif
