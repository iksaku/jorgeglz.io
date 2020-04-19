<?php
/** @var App\User $user */
/** @var string $content */
/** @var string $introductoryPhrase */
?>

@extends('blog.partials.template')

@section('title', 'About')

@push('meta')
    <meta name="description" content="Here you can get a gist of who I am, and what do I like.">
@endpush

@section('content')
    <div class="md:max-w-6xl bg-white dark:bg-gray-800 border border-gray-300 rounded shadow p-4 mx-auto">
        <h1 class="text-3xl text-center font-bold mb-4">
            {!! $introductoryPhrase !!}
        </h1>

        <img src="{{ $user->avatar }}?size=512" alt="Jorge's avatar" class="h-64 w-64 block mx-auto rounded-full">

        <article class="markdown">
            @markdown($content)
        </article>
    </div>
@endsection
