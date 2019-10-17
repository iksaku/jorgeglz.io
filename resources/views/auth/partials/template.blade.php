@extends('main')

@section('body')
    <div class="min-h-screen w-full flex flex-col items-center justify-center">
        <h1 class="text-4xl font-bold mb-10">@yield('message')</h1>

        <div class="max-w-sm w-full">
            @yield('form')
        </div>
    </div>
@endsection
