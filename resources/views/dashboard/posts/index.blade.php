<?php /** @var \App\Post[] $posts */ ?>

@extends('dashboard.partials.template')

@section('title', __('Posts'))

@section('content')
    <div class="h-full min-w-0 w-full flex items-start justify-center">
        <div class="w-full p-4 md:px-6">
            <div class="w-full mb-4 flex items-center justify-end">
                <div class="flex items-center justify-between">
                    <a
                        role="button"
                        href="{{ route('dashboard.posts.create') }}"
                        class="text-gray-700 hocus:text-gray-100 text-center bg-gray-100 hocus:bg-blue-500 focus:outline-none px-4 py-2 rounded-lg shadow"
                    >
                        <span class="fas fa-plus mr-2"></span>
                        <span class="font-medium">New Post</span>
                    </a>
                </div>
            </div>

            <div class="-mx-4 md:mx-0 overflow-hidden">
                <div class="w-full border-2 shadow md:rounded-lg overflow-x-auto">
                    <table class="min-w-full text-gray-600 tracking-wide">
                        {{-- Table Head --}}
                        <thead class="text-gray-700 text-sm bg-gray-300 font-semibold uppercase">
                        <tr class="border-b border-gray-200">
                            <th class="px-4 md:px-6 py-2 text-center">ID</th>
                            <th class="px-4 md:px-6 py-2 text-center">Status</th>
                            <th class="px-4 md:px-6 py-2 text-left">Title</th>
                            <th class="px-4 md:px-6 py-2 text-center"></th>
                        </tr>
                        </thead>

                        {{-- Table Body --}}
                        <tbody class="font-medium text-gray-800 text-base bg-white">
                        @foreach($posts as $post)
                            <tr class="border-b last:border-0 border-gray-200">
                                {{-- ID --}}
                                <td class="px-4 md:px-6 py-2 text-center">
                                    {{-- Font Tabular Nums --}}
                                    {{ $post->id }}
                                </td>

                                {{-- Status --}}
                                <td class="px-4 md:px-6 py-2 text-center">
                                    @if($post->trashed())
                                        <span class="fas fa-archive text-red-500"></span>
                                    @elseif(!$post->published)
                                        <span class="fas fa-file-alt text-purple-500"></span>
                                    @else
                                        <span class="fas fa-check text-green-500"></span>
                                    @endif
                                </td>

                                {{-- Title --}}
                                <td class="max-w-sm xl:max-w-2xl px-4 md:px-6 py-2 truncate">
                                    {{ $post->title }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 md:px-6 py-2 text-center text-gray-600 whitespace-no-wrap">
                                    @if($post->trashed())
                                        <form action="{{ route('dashboard.posts.restore', $post) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <button
                                                type="submit"
                                                onclick="return confirm('Would you like to restore post \'{{ $post->title }}\'?')"
                                                class="hocus:text-yellow-600 transform duration-200 hocus:scale-150"
                                            >
                                                <span class="fas fa-trash-restore"></span>
                                            </button>
                                        </form>
                                    @else
                                        <a class="inline-block align-middle hocus:text-indigo-700 transform duration-200 hocus:scale-150 mx-2" href="{{ route('dashboard.posts.show', $post) }}">
                                            <span class="fas fa-eye"></span>
                                        </a>
                                        <a class="inline-block align-middle hocus:text-indigo-700 transform duration-200 hocus:scale-150 mx-2" href="{{ route('dashboard.posts.edit', $post) }}">
                                            <span class="fas fa-pencil"></span>
                                        </a>
                                        <form class="inline-block align-middle mx-2" action="{{ route('dashboard.posts.destroy', $post) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button
                                                type="submit"
                                                onclick="return confirm('Are you sure you want to archive post \'{{ $post->title }}\'?')"
                                                class="hocus:text-red-700 transform duration-200 hocus:scale-150"
                                            >
                                                <span class="fas fa-archive"></span>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{ $posts->onEachSide(2)->links('components.pagination.tailwind') }}
        </div>
    </div>
@endsection
