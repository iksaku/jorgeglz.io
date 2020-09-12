<?php /** @var App\Models\Post $post */ ?>

@section('title', $post->title)

<x-meta og="title" :content="$post->title" />
<x-meta og="description" :content="markdown($post, true)" />

<x-use.highlight />

<div class="max-w-6xl mx-auto space-y-4">
    @auth
        <div class="z-20 sticky top-4 inset-x-0 flex-shrink-0 flex items-center justify-center space-x-4">
            <a
                role="button"
                href="{{ route('dashboard.posts.edit', $post) }}"
                class="hocus:text-gray-100 text-center bg-gray-100 dark:bg-gray-700 hocus:bg-purple-600 focus:shadow-outline focus:outline-none px-4 py-2 ml-2 border border-gray-400 dark:border-gray-600 hocus:border-transparent rounded-lg transform duration-200"
                x-ref="edit"
                @keydown.ctrl.e.prevent.window="$refs.edit.click()"
            >
                <span class="fas fa-pencil mr-2"></span>
                <span class="font-medium">Edit</span>
            </a>
            <form class="ml-2" action="{{ route('dashboard.posts.destroy', $post) }}" method="post">
                @method('delete')
                @csrf
                <button
                    type="submit"
                    class="text-gray-100 text-center bg-red-500 hocus:bg-red-700 focus:shadow-outline focus:outline-none px-4 py-2 rounded-lg transform duration-200"
                    @click="return confirm('Are you sure you want to archive post \'{{ $post->title }}\'?')"
                    x-ref="delete"
                    @keydown.ctrl.d.prevent.window="$refs.delete.click()"
                >
                    <span class="fas fa-archive"></span>
                </button>
            </form>
        </div>
    @endauth

    <div class="bg-gray-100 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg divide-y divide-gray-400 dark:divide-gray-600">
        <x-blog.post.info :post="$post" :link="false" />

        <article class="markdown p-4">
            @markdown($post)
        </article>
    </div>
</div>
