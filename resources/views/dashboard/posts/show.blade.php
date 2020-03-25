<?php /** @var \App\Post $post */ ?>

@extends('dashboard.partials.template')

@section('title', 'View Post')

@section('content')
    <div class="h-full w-full flex items-start justify-center">
        <div class="w-full p-4 md:px-6">
            <div class="w-full mb-8">
                <div class="w-full mb-4 flex items-center justify-between">
                    <h3 class="text-2xl text-gray-900 font-medium">Details</h3>

                    <div class="flex items-center justify-between -mx-2">
                        <form action="{{ route('dashboard.posts.destroy', $post) }}" method="post">
                            @method('delete')
                            @csrf
                            <button
                                type="submit"
                                onclick="return confirm('Are you sure you want to archive post {{ $post->title }}?')"
                                class="text-gray-100 text-center bg-red-500 hocus:bg-red-700 focus:outline-none px-4 py-2 mx-2 rounded-lg shadow"
                            >
                                <span class="fas fa-archive"></span>
                            </button>
                        </form>
                        <a
                            role="button"
                            href="{{ route('dashboard.posts.edit', $post) }}"
                            class="text-gray-700 text-center bg-gray-100 hocus:text-gray-100 hocus:bg-blue-500 focus:outline-none px-4 py-2 mx-2 rounded-lg shadow"
                        >
                            <span class="fas fa-pencil mr-2"></span>
                            <span class="font-medium">Edit</span>
                        </a>
                    </div>
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
                        <tr class="border-b-2">
                            <td class="px-4 py-2 text-sm text-gray-700 font-semibold uppercase">ID</td>
                            <td class="px-4 py-2">{{ $post->id }}</td>
                        </tr>
                        <tr class="border-b-2">
                            <td class="px-4 py-2 text-sm text-gray-700 font-semibold uppercase">Title</td>
                            <td class="px-4 py-2">{{ $post->title }}</td>
                        </tr>
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
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-full">
                <div class="w-full mb-2">
                    <h3 class="text-2xl text-gray-900 font-medium">Content</h3>
                </div>

                <div class="w-full bg-gray-100 rounded-lg shadow">
                    <article class="markdown p-4">
                        @markdown($post)
                    </article>
                </div>
            </div>
        </div>
    </div>
@endsection
