<?php /** @var App\Post $post */ ?>

@extends('dashboard.partials.template')

@section('title', $post->title)
@section('view-title', 'View Post')

@section('content')
    <div class="h-full min-w-0 w-full p-4 md:px-6">
        <div class="w-full flex flex-col md:flex-row items-center justify-between mb-4">
            <a class="hocus:shadow-outline focus:outline-none md:mr-4 mb-4 md:mb-0 transform duration-200" href="{{ route('blog.post', $post) }}">
                <h2 class="max-w-full text-2xl text-center md:text-left font-medium">
                    {{ $post->title }}
                </h2>
            </a>

            <div class="flex-shrink-0 flex items-center justify-between">
                @if(!$post->published)
                    <form action="{{ route('dashboard.posts.update', $post) }}" method="post">
                        @csrf
                        @method('patch')

                        <input type="hidden" name="published_at" value="{{ now() }}">
                        <button
                            class="w-full text-gray-100 bg-blue-500 hocus:bg-blue-700 focus:shadow-outline focus:outline-none px-4 py-2 rounded-lg transform duration-200"
                            type="submit"
                        >
                            <span class="fas fa-paper-plane mr-2"></span>
                            <span class="font-medium">Publish</span>
                        </button>
                    </form>
                @endif
                <a
                    role="button"
                    href="{{ route('dashboard.posts.edit', $post) }}"
                    class="text-gray-700 hocus:text-gray-100 text-center bg-gray-100 hocus:bg-blue-500 focus:shadow-outline focus:outline-none px-4 py-2 ml-2 rounded-lg shadow transform duration-200"
                >
                    <span class="fas fa-pencil mr-2"></span>
                    <span class="font-medium">Edit</span>
                </a>
                <form class="ml-2" action="{{ route('dashboard.posts.destroy', $post) }}" method="post">
                    @method('delete')
                    @csrf
                    <button
                        type="submit"
                        onclick="return confirm('Are you sure you want to archive post \'{{ $post->title }}\'?')"
                        class="text-gray-100 text-center bg-red-500 hocus:bg-red-700 focus:shadow-outline focus:outline-none px-4 py-2 rounded-lg shadow transform duration-200"
                    >
                        <span class="fas fa-archive"></span>
                    </button>
                </form>
            </div>
        </div>

        <div class="w-full flex flex-col md:flex-row items-start justify-evenly">
            <div class="flex-grow w-full md:pr-2">
                <div>
                    <span class="block text-xl font-medium">
                        Content
                    </span>
                    <div class="bg-gray-100 border rounded-lg shadow overflow-hidden p-4">
                        <article class="markdown">
                            @markdown($post->content)
                        </article>
                    </div>
                </div>
            </div>

            <div class="flex-shrink-0 order-first md:order-none w-full md:w-1/3 md:pl-2">
                <div class="mb-4">
                    <span class="block text-xl font-medium">
                        Details
                    </span>
                    <div class="bg-gray-100 border rounded-lg shadow overflow-hidden p-4">
                        <div class="mb-2 flex">
                            <span class="w-1/3">
                                Created
                            </span>
                            <span class="w-2/3">
                                {{ $post->created_at->format('F j, Y') }}
                            </span>
                        </div>
                        <div class="mb-0 flex">
                            <span class="w-1/3">
                                Published
                            </span>
                            <span class="w-2/3">
                                @if(!$post->published)
                                    <span class="italic text-gray-700">
                                        Not published yet
                                    </span>
                                @else
                                    {{ $post->published_at->format('F j, Y') }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
