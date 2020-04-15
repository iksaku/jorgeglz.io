@extends('dashboard.partials.template')

@section('title', 'Dashboard')

@section('content')
    <div class="h-full w-full flex items-start justify-start bg-gray-200 p-4">
        <x-dashboard.analytic-card class="w-1/3 mr-4">
            <div class="text-gray-700 font-bold">
                Published Posts
            </div>
            <div class="text-4xl text-green-700 font-semibold">
                {{ App\Post::isPublished()->count() }}
            </div>
        </x-dashboard.analytic-card>

        <x-dashboard.analytic-card class="w-1/3 mr-4">
            <div class="text-gray-700 font-bold">
                Draft Posts
            </div>
            <div class="text-4xl text-purple-700 font-semibold">
                {{ App\Post::isDraft()->count() }}
            </div>
        </x-dashboard.analytic-card>
    </div>
@endsection
