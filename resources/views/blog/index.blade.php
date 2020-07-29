<?php /** @var Illuminate\Contracts\Pagination\LengthAwarePaginator|App\Post[] $posts */ ?>

@extends('layouts.blog')

<x-meta og="title" content="JorgeGlz Blog" />
<x-meta og="description" content="Hello! I have a blog! And here you can find... Well... Blog posts..." />

@section('content')
    @if($posts->isNotEmpty())
        <div class="max-w-6xl mx-auto space-y-4">
            @foreach ($posts as $post)
                <x-blog.post.preview :post="$post" />
            @endforeach

            <div class="w-full flex items-center justify-center">
                {{ $posts->onEachSide(2)->links() }}
            </div>
        </div>
    @else
        <div class="w-full self-center text-center text-2xl italic font-light">
            No posts available right now.
        </div>
    @endif
@endsection
