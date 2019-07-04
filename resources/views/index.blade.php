@extends('template')

@section('title', 'Jorge González')

@section('content')
    <div id="app">
        <router-view></router-view>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endpush