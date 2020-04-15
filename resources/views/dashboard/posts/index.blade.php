<?php /** @var Illuminate\Pagination\LengthAwarePaginator|App\Post[] $posts */ ?>

@extends('dashboard.partials.template')

@section('title', __('Posts'))

@section('content')
    <livewire:dashboard.post.index />
@endsection
