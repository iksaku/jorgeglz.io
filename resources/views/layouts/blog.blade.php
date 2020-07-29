@extends('layouts.base')

<x-meta og="image" content="{{ avatar('iksaku@me.com', 512) }}" />
<x-meta og="url" content="{{ request()->url() }}" />
<x-meta name="twitter:site" content="@iksaku2" />
<x-meta name="twitter:card" content="summary" />

<x-use.fontawesome />

@section('body')
    <div class="min-h-screen w-full flex flex-col">
        <x-blog.header />

        <div class="flex-grow md:container flex md:px-4 py-4 md:mx-auto">
            @yield('content')
        </div>

        <x-blog.footer />
    </div>
@endsection
