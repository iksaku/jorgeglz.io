<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- Meta Tags --}}
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        @stack('meta')

        {{-- Title --}}
        @hasSection('title')
            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif

        {{-- Styles --}}
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <link rel="dns-prefetch" href="https://rsms.me">
        <link rel="preconnect" href="https://rsms.me">
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <link rel="dns-prefetch" href="//secure.gravatar.com">
        <link rel="preconnect" href="//secure.gravatar.com">

        @stack('styles')
    </head>
    <body class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-gray-100 scrolling-touch">
        @yield('body')

        {{-- Scripts --}}
        @stack('scripts')
    </body>
</html>
