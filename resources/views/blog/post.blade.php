<?php /** @var App\Post $post */ ?>

@extends('blog.partials.template')

@section('title', $post->title)

@section('content')
    <div class="w-full md:max-w-6xl bg-gray-100 border border-gray-300 rounded shadow mx-auto">
        <h1 class="border-b-2 border-gray-300 rounded p-4 pb-2">
            <span class="text-black text-2xl font-bold">
                {{ $post->title }}
            </span>

            @include('blog.components.post-info')
        </h1>

        <article class="markdown p-4">
            @markdown($post->content)
        </article>
    </div>
@endsection
