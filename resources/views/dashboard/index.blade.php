@extends('dashboard.partials.template')

@section('title', 'Dashboard')

@section('content')
    <div class="h-full w-full flex items-start justify-start p-4">
        <x-dashboard.analytic-card class="w-1/3 mr-4">
            <div class="font-bold">
                Published Posts
            </div>
            <div class="text-4xl text-green-700 dark:text-green-500 font-semibold">
                {{ App\Post::isPublished()->count() }}
            </div>
        </x-dashboard.analytic-card>

        <x-dashboard.analytic-card class="w-1/3 mr-4">
            <div class="font-bold">
                Draft Posts
            </div>
            <div class="text-4xl text-purple-700 dark:text-purple-500 font-semibold">
                {{ App\Post::isDraft()->count() }}
            </div>
        </x-dashboard.analytic-card>
    </div>
@endsection
