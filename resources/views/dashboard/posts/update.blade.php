<?php /** @var \App\Post $post */ ?>

@extends('dashboard.partials.template')

@section('title', __($post->exists ? 'Edit Post' : 'New Post'))

@section('content')
    <div
        x-data="formData()"
        class="h-full w-full flex items-start justify-center"
    >
        <form
            x-ref="form"
            class="hidden"
            action="{{ route('dashboard.posts.' . ($post->exists ? 'update' : 'store'), $post) }}"
            method="post"
        >
            @if($post->exists) @method('put') @endif
            @csrf

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
                    {{--<article class="markdown p-4">
                        @markdown($post)
                    </article>--}}
                    <div class="w-full border" x-text="content" contenteditable=""></div>
                    <div class="w-full" x-text="content"></div>192.
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function formData() {
            return {
                title: `{{ old('title', $post->title) }}`,
                content: `{{ old('content', $post->content) }}`
            }
        }
    </script>
@endpush
