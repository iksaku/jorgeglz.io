@extends('main')

@section('body')
    <div class="min-h-screen h-full w-full flex flex-col">
        @auth
            @include('auth.partials.header')
        @endauth

        <div class="w-full flex flex-col flex-grow items-center justify-center p-4">
            <h1 class="text-4xl text-gray-700 text-center font-bold">
                @yield('message')
            </h1>

            <div class="max-w-sm w-full my-4">
                <div class="max-w-sm w-full bg-gray-100 rounded shadow">
                    @if(View::hasSection('alert'))
                        <div
                            class="w-full text-sm text-white text-center font-bold bg-blue-500 rounded-t px-4 py-2"
                            role="alert"
                        >
                            @yield('alert')
                        </div>
                    @endif

                    <div class="w-full px-4 py-8">
                        @yield('contents')
                    </div>
                </div>
            </div>
        </div>

        @include('auth.partials.footer')
    </div>
@endsection
