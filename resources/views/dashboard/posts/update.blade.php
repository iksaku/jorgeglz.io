<?php /** @var App\Post $post */ ?>

@extends('dashboard.partials.template')

@section('title', __($post->exists ? 'Edit Post' : 'New Post'))

<x-use.highlight />

@section('content')
    {{-- TODO: Alert on unsaved changes --}}
    <form
        class="h-full min-w-0 w-full md:px-6 py-4"
        action="{{ route('dashboard.posts.' . ($post->exists ? 'update' : 'store'), $post) }}"
        method="post"
    >
        @csrf
        @if($post->exists)
            @method('patch')
        @endif

        <div class="w-full flex flex-col md:flex-row items-stretch justify-between px-4 md:px-0 mb-4">
            <label class="flex-grow pr-2 mb-4 md:mb-0">
                <div class="text-xl font-medium">Title</div>
                <input
                    required
                    name="title"
                    type="text"
                    placeholder="The One Above All"
                    value="{{ old('title', $post->title) }}"
                    class="w-full bg-white px-4 py-2 focus:shadow-outline focus:outline-none border border-gray-400 focus:border-transparent rounded-lg truncate transform duration-200 @error('title') border-red-500 @enderror"
                    @if(!$post->exists)
                        autofocus
                    @endif
                >
                <x-input-error property="slug" />
                <x-input-error property="title" />
            </label>

            <div class="flex-shrink-0 w-full md:w-1/3 md:pl-2 flex items-center justify-evenly md:justify-end">
                <button
                    class="text-gray-100 bg-blue-500 hocus:bg-blue-700 focus:shadow-outline focus:outline-none px-4 py-2 rounded-lg transform duration-200"
                    type="submit"
                >
                    <span class="fas fa-save mr-2"></span>
                    <span class="font-medium">Save</span>
                </button>
                <a
                    role="button"
                    href="{{ route('dashboard.posts.show', $post) }}"
                    class="text-gray-100 whitespace-no-wrap bg-red-500 hocus:bg-red-700 focus:shadow-outline focus:outline-none px-4 py-2 ml-2 rounded-lg transform duration-200"
                >
                    <span class="fas fa-times mr-2"></span>
                    <span class="font-medium">Cancel</span>
                </a>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-start justify-evenly">
            <div class="min-w-0 flex-grow w-full md:pr-2">
                <div class="text-xl font-medium px-4 md:px-0">
                    Content
                </div>
                <livewire:dashboard.post.preview :post="$post" :content="old('content')" />
            </div>

            <div class="flex-shrink-0 order-first md:order-none w-full md:w-1/3 md:pl-2">
                @if($post->exists)
                    <div class="mb-4">
                        <div class="text-xl font-medium">
                            Details
                        </div>
                        <div class="bg-white border border-gray-400 md:rounded-lg overflow-hidden p-4">
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
                                    @if(!$post->published())
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
                @endif
            </div>
        </div>
    </form>
@endsection
