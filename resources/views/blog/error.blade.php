@extends('blog.partials.template')

<?php
    if (!isset($code)) $code = '404';
    if (!isset($message)) $message = 'Resource not found.';
?>

@push('meta')
    <meta name="description" content="It looks like you reached a dark place. Please get back immediately.">
@endpush

@yield('title', $code)

@section('content')
    <div class="h-full flex items-center justify-center text-gray-800">
        <h1
            class="text-right text-6xl pr-2 mr-2 border-r-2 border-gray-500"
        >
            {{ $code }}
        </h1>
        <p class="max-w-sm text-left text-2xl">
            {{ $message }}
        </p>
    </div>
@endsection
