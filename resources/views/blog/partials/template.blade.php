@extends('main')

@section('body')
    <div class="min-h-screen h-full w-full flex flex-col">
        @include('blog.partials.header')

        <div class="flex-grow w-full lg:container lg:mx-auto lg:p-4">
            @yield('content')
        </div>

        @include('blog.partials.footer')
    </div>
@endsection
