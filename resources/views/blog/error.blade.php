@extends('layouts.blog')

@section('title', $code)

<x-meta og="title" content="Oops..." />
<x-meta og="description" content="It looks like you reached a dark place. Please get back immediately." />

@section('content')
    @include('components.error')
@endsection
