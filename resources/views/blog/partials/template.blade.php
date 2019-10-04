@extends('main')

@section('body')
    <div class="min-h-screen h-full w-full flex flex-col">
        @include('blog.partials.header')

        <div class="h-full w-full flex-1">
            <div class="h-full container mx-auto p-4">
                @yield('content')
            </div>
        </div>

        @include('blog.partials.footer')
    </div>
@endsection
