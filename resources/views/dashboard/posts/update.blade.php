<?php /** @var App\Post $post */ ?>

@extends('dashboard.partials.template')

@section('title', __($post->exists ? 'Edit Post' : 'New Post'))

@section('content')
    {{--<div
        x-data="formData()"
        class="h-full min-w-0 w-full p-4 md:px-6"
    >
        <form
            x-ref="form"
            class="hidden"
            action="{{ route('dashboard.posts.' . ($post->exists ? 'update' : 'store'), $post) }}"
            method="post"
        >
            @csrf
            @if($post->exists) @method('put') @endif

            <label>
                <input name="title" type="text" readonly x-model="title">
            </label>

            <label>
                <input name="content" type="text" readonly x-model="content">
            </label>
        </form>

        <div class="w-full p-4 md:px-6">
            <div class="w-full mb-8">
                <div class="w-full mb-4 flex items-center justify-between">
                    <h3 class="text-2xl text-gray-900 font-medium">Details</h3>
                </div>

                <div class="w-full bg-gray-100 rounded-lg shadow">
                    <table class="w-full text-gray-900 text-left table table-fixed">
                        <thead>
                        <tr class="w-full">
                            <th class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/6"></th>
                            <th class="w-auto"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($post->exists)
                            <tr class="border-b-2">
                                <td class="px-4 py-2 text-sm text-gray-700 font-semibold uppercase">ID</td>
                                <td class="px-4 py-2">{{ $post->id}}</td>
                            </tr>
                        @endif
                        <tr class="border-b-2">
                            <td class="px-4 py-2 text-sm text-gray-700 font-semibold uppercase">
                                <label for="title">Title</label>
                            </td>
                            <td class="px-4 py-2">
                                <input
                                    id="title"
                                    autofocus
                                    required
                                    type="text"
                                    name="title"
                                    placeholder="An Awesome Title"
                                    class="w-full bg-transparent"
                                    x-model="title"
                                >
                            </td>
                        </tr>
                        @if($post->exists)
                            <tr class="border-b-2">
                                <td class="px-4 py-2 text-sm text-gray-700 font-semibold uppercase">Created At</td>
                                <td class="px-4 py-2">{{ $post->created_at }}</td>
                            </tr>
                            <tr class="border-b-2">
                                <td class="px-4 py-2 text-sm text-gray-700 font-semibold uppercase">Updated At</td>
                                <td class="px-4 py-2">{{ $post->updated_at }}</td>
                            </tr>
                            <tr class="border-b-0">
                                <td class="px-4 py-2 text-sm text-gray-700 font-semibold uppercase">Published At</td>
                                <td class="px-4 py-2">{{ $post->published_at }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-full">
                <div class="w-full mb-2">
                    <h3 class="text-2xl text-gray-900 font-medium">
                        <label for="content">Content</label>
                    </h3>
                </div>

                <div class="w-full bg-gray-100 rounded-lg shadow" x-data="{ content: `{{ $post->content }}`}">
                    --}}{{--<article class="markdown p-4">
                        @markdown($post)
                    </article>--}}{{--
                    <div class="w-full border" x-text="content" contenteditable=""></div>
                    <div class="w-full" x-text="content"></div>192.
                </div>
            </div>
        </div>
    </div>--}}
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
            <label class="flex-grow pr-2 flex flex-col">
                <span class="text-xl font-medium">Title</span>
                <input
                    required
                    name="title"
                    type="text"
                    placeholder="The One Above All"
                    value="{{ old('title', $post->title) }}"
                    class="w-full bg-gray-100 px-4 py-2 focus:shadow-outline focus:outline-none rounded-lg shadow truncate transform duration-200"
                    @if(!$post->exists)
                        autofocus
                    @endif
                >
                <x-dashboard.input-error property="slug" />
                <x-dashboard.input-error property="title" />
            </label>
            {{--<a class="hocus:shadow-outline focus:outline-none md:mr-4 mb-4 md:mb-0 transform duration-200" href="{{ route('blog.post', $post) }}">
                <h2 class="max-w-full text-2xl text-center md:text-left font-medium">
                    {{ $post->title }}
                </h2>
            </a>--}}

            <div class="flex-shrink-0 w-1/3 pl-2 flex items-end justify-end">
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

        <div class="w-full flex items-start justify-evenly">
            <div class="flex-grow pr-2">
                <div>
                    <span class="block text-xl font-medium">
                        Content
                    </span>

                    <livewire:post-preview-content :post="$post" :content="old('content')" />
                </div>
            </div>

            <div class="flex-shrink-0 w-1/3 pl-2">
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
