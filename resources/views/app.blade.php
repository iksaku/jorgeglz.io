<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- Meta Tags --}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if (isset($meta))
            @foreach ($meta as $name => $content)
                <meta name="{{ $name }}" content="{{ $content }}">
            @endforeach
        @endif

        {{-- Title --}}
        <title>
            @if (isset($title))
                {{ $title }} |
            @endif
            {{ config('app.name') }}
        </title>

        {{-- Styles --}}
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body>
        @inertia

        {{-- Scripts --}}
        <script src="{{ mix('js/app.js') }}" defer></script>
    </body>
</html>
