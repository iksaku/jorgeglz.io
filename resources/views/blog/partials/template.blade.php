@extends('main')

<x-use.fontawesome />

@section('body')
    <div class="min-h-screen h-full w-full flex flex-col">
        @include('blog.partials.header')

        <div class="flex-grow w-full flex md:container md:px-4 py-4 md:mx-auto">
            @yield('content')
        </div>

        @include('blog.partials.footer')
    </div>
@endsection
