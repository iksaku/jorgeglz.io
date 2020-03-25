<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @stack('meta')

    <title>
        {{ app_title() }}
    </title>

    {{-- Styles --}}
    <link rel="dns-prefetch" href="//rsms.me">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('styles')
</head>
<body class="bg-gray-200 scrolling-touch font-sans">
    @yield('modals')

    @yield('body')

    {{-- Scripts --}}
    <script src="{{ mix('js/fontawesome.js') }}" defer></script>
    <script src="{{ mix('js/alpine.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
