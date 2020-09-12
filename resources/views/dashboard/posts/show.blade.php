<?php /** @var \App\Models\Post $post */ ?>

@extends('dashboard.partials.template')

@section('title', $post->title)
@section('view-title', 'View Post')

<x-use.highlight />

@section('content')
    <div x-data class="h-full min-w-0 w-full md:px-6 py-4">
        <div class="w-full flex flex-col md:flex-row items-center justify-between px-4 md:px-0 mb-4">
            <a
                href="{{ route('blog.post', $post) }}"
                target="_blank"
                class="hocus:shadow-outline focus:outline-none md:mr-4 mb-4 md:mb-0 transform duration-200"
            >
                <h2 class="max-w-full text-2xl text-center md:text-left font-semibold">
                    {{ $post->title }}
                </h2>
            </a>

            <div class="flex-shrink-0 flex items-center justify-between">
                @if(!$post->published)
                    <form
                        action="{{ route('dashboard.posts.update', $post) }}"
                        method="post"
                        x-ref="publish"
                        @keydown.ctrl.p.prevent.window="$refs.publish.submit()"
                    >
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
                @else
                    <a
                        role="button"
                        href="{{ route('blog.post', $post) }}"
                        target="_blank"
                        class="hocus:text-gray-100 text-center bg-gray-100 dark:bg-gray-700 hocus:bg-blue-500 focus:shadow-outline focus:outline-none px-4 py-2 border border-gray-400 dark:border-gray-600 hocus:border-transparent rounded-lg transform duration-200"
                        x-ref="view"
                        @keydown.ctrl.v.prevent.window="$refs.view.click()"
                    >
                        <span class="fas fa-eye"></span>
                    </a>
                @endif
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
        </div>

        <div class="flex flex-col md:flex-row items-start justify-evenly">
            <div class="flex-grow min-w-0 w-full md:pr-2">
                <div class="text-xl font-medium px-4 md:px-0">
                    Content
                </div>
                <div class="bg-gray-100 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg overflow-hidden">
                    <article class="markdown p-4">
                        @markdown($post)
                    </article>
                </div>
            </div>

            <div class="flex-shrink-0 order-first md:order-none w-full md:w-1/3 md:pl-2">
                <div class="mb-4">
                    <div class="text-xl font-medium px-4 md:px-0">
                        Details
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 font-medium md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg overflow-hidden p-4">
                        <div class="mb-2 flex">
                            <span class="w-1/3">
                                Created
                            </span>
                            <span class="w-2/3 text-right xl:text-left">
                                {{ $post->created_at->format('F j, Y') }}
                            </span>
                        </div>
                        <div class="mb-0 flex">
                            <span class="w-1/3">
                                Published
                            </span>
                            <span class="w-2/3 text-right xl:text-left">
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
