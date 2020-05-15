<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @stack('meta')

    <title>
        @hasSection('title')
            @yield('title') |
        @endif
        {{ config('app.name') }}
    </title>

    {{-- Styles --}}
    <link rel="dns-prefetch" href="//rsms.me">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <link rel="dns-prefetch" href="//secure.gravatar.com">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('styles')
</head>
<body class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-gray-100 scrolling-touch font-sans">
    @yield('body')

    {{-- Scripts --}}
    @stack('scripts')
</body>
</html>
