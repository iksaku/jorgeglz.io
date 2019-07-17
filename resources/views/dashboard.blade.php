@extends('template')

@section('title', 'Jorge González')

@section('content')
    <div id="dashboard"></div>
@endsection

@push('scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/dashboard.js') }}"></script>
@endpush
