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
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('styles')

    {{-- Scripts --}}
    @stack('scripts')
    <script src="{{ mix('js/fontawesome.js') }}" defer></script>

    {{-- LiveWire --}}
    @livewireAssets
</head>
<body>
    @yield('body')
</body>
</html>
