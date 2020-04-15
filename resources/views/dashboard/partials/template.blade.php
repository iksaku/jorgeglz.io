@extends('main')

<x-use.alpine />
<x-use.fontawesome />
<x-use.livewire />

@section('body')
    <div
        x-data="bodyData()"
        x-init="init()"
        class="min-h-screen h-full w-full bg-gray-200 flex overflow-auto"
    >
        @include('dashboard.partials.sidebar')

        <div class="min-w-0 flex-1 w-full flex flex-col">
            @include('dashboard.partials.header')

            <div class="min-w-0 flex-grow w-full flex">
                @yield('content')
            </div>

            @include('dashboard.partials.footer')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function bodyData() {
            return {
                sidebarOpen: false,
                init() {
                    this.$refs.sidebar.classList.remove('-translate-x-full')
                }
            }
        }
    </script>
@endpush
