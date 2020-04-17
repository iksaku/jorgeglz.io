<?php /** @var Illuminate\Contracts\Pagination\LengthAwarePaginator|App\Post[] $posts */ ?>

@extends('blog.partials.template')

@push('meta')
    <meta name="description" content="Hello! I have a blog! And here you can find... Well... Blog posts...">
@endpush

@section('content')
    @if($posts->isNotEmpty())
        <div class="w-full md:max-w-6xl mx-auto">
            @foreach ($posts as $post)
                <x-blog.post.preview :post="$post" />
            @endforeach

            <div class="w-full flex items-center justify-center mt-4">
                {{ $posts->onEachSide(2)->links() }}
            </div>
        </div>
    @else
        <div class="h-full w-full flex items-center justify-center">
            <p class="text-center text-gray-800 text-2xl italic font-light">
                No posts available right now.
            </p>
        </div>
    @endif
@endsection
