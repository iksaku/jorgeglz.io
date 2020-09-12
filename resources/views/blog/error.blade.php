@extends('layout.blog')

@section('title', $code)

<x-meta og="title" content="Oops..." />
<x-meta og="description" content="It looks like you reached a dark place. Please get back immediately." />

@section('content')
    <div class="flex-grow flex flex-col items-center justify-center space-y-4">
        <div class="text-6xl text-center">
            {{ $code }}
        </div>

        <div class="text-3xl text-center">
            {{ $message }}
        </div>
    </div>
@endsection
