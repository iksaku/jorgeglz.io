@extends('layout.base')

<x-use.alpine />
<x-use.fontawesome />
<x-use.livewire />

@section('body')
    <div
        x-data="{ sidebarOpen: false }"
        x-init="$refs.sidebar.classList.remove('-translate-x-full')"
        class="min-h-screen h-full w-full flex overflow-auto"
    >
        <x-dashboard.sidebar />

        <div class="min-w-0 flex-1 w-full flex flex-col">
            <x-dashboard.header />

            <div class="min-w-0 flex-grow w-full flex">
                @yield('content')
            </div>

            <x-dashboard.footer />
        </div>
    </div>
@endsection
