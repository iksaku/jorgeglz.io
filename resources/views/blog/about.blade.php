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
    <div class="md:max-w-6xl bg-gray-100 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg p-4 mx-auto space-y-4">
        <h1 class="text-3xl text-center font-bold">
            {!! $introductoryPhrase !!}
        </h1>

        <img src="{{ $user->avatar }}?size=512" alt="Jorge's avatar" class="h-32 md:h-64 w-32 md:w-64 block mx-auto rounded-full">

        <article class="markdown">
            @markdown($content)
        </article>
    </div>
@endsection
