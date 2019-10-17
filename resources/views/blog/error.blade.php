<?php /** @var \Symfony\Component\HttpKernel\Exception\HttpException $exception */ ?>

@extends('blog.partials.template')

@section('title', $exception->getStatusCode())

@push('meta')
    <meta name="description" content="It looks like you reached a dark place. Please get back immediately.">
@endpush

@section('content')
    <div class="h-full flex items-center justify-center text-gray-800">
        <h1
            class="text-right text-6xl pr-2 mr-2 border-r-2 border-gray-500"
        >
            {{ $exception->getStatusCode() }}
        </h1>
        <p class="max-w-sm text-left text-2xl">
            {{ $exception->getMessage() ?: 'Resource not found.' }}
        </p>
    </div>
@endsection
