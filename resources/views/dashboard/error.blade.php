@extends('dashboard.partials.template')

@section('title', $code)

@push('meta')
    <meta name="description" content="It looks like you reached a dark place. Please get back immediately.">
@endpush

@section('content')
    @include('components.error')
@endsection
