<?php /** @var App\Post $post */ ?>

@extends('dashboard.partials.template')

@section('title', __($post->exists ? 'Edit Post' : 'New Post'))

@section('content')
    {{-- TODO: Alert on unsaved changes --}}
    <form
        class="h-full min-w-0 w-full p-4 md:px-6"
        action="{{ route('dashboard.posts.' . ($post->exists ? 'update' : 'store'), $post) }}"
        method="post"
    >
        @csrf
        @if($post->exists)
            @method('patch')
        @endif

        <div class="w-full flex flex-col md:flex-row items-stretch justify-between mb-4">
            <label class="flex-grow pr-2 flex flex-col mb-4 md:mb-0">
                <span class="text-xl font-medium">Title</span>
                <input
                    required
                    name="title"
                    type="text"
                    placeholder="The One Above All"
                    value="{{ old('title', $post->title) }}"
                    class="w-full bg-gray-100 px-4 py-2 focus:shadow-outline focus:outline-none rounded-lg shadow truncate transform duration-200 @error('title') border border-red-500 @enderror"
                    @if(!$post->exists)
                        autofocus
                    @endif
                >
                <x-input-error property="slug" />
                <x-input-error property="title" />
            </label>

            <div class="flex-shrink-0 w-full md:w-1/3 md:pl-2 flex items-end justify-evenly md:justify-end">
                <button
                    class="text-gray-100 bg-blue-500 hocus:bg-blue-700 focus:shadow-outline focus:outline-none px-4 py-2 rounded-lg transform duration-200"
                    type="submit"
                >
                    <span class="fas fa-save mr-2"></span>
                    <span class="font-medium">Save</span>
                </button>
                <a
                    role="button"
                    href="{{ url()->previous(true) }}"
                    class="text-gray-100 whitespace-no-wrap bg-red-500 hocus:bg-red-700 focus:shadow-outline focus:outline-none px-4 py-2 ml-2 rounded-lg shadow transform duration-200"
                >
                    <span class="fas fa-times mr-2"></span>
                    <span class="font-medium">Cancel</span>
                </a>
            </div>
        </div>

        <div class="w-full flex flex-col md:flex-row items-start justify-evenly">
            <div class="flex-grow w-full md:pr-2">
                <div>
                    <span class="block text-xl font-medium">
                        Content
                    </span>

                    <livewire:dashboard.post.preview :post="$post" :content="old('content')" />
                </div>
            </div>

            <div class="flex-shrink-0 order-first md:order-none w-full md:w-1/3 md:pl-2">
                @if($post->exists)
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
                @endif
            </div>
        </div>
    </form>
@endsection
