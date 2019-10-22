@extends('dashboard.partials.template')

@section('title', 'Dashboard')

@section('content')
    <div class="min-h-screen w-full flex items-center justify-center bg-gray-200">
        @include('components.logout')
    </div>
@endsection
