@section('title', 'Dashboard')

<div class="w-full flex items-start justify-start p-4 space-x-4">
    <x-dashboard.analytic-card class="w-1/2 md:w-1/3">
        <div class="font-bold">
            Published Posts
        </div>
        <div class="text-4xl text-green-700 dark:text-green-500 font-semibold">
            {{ $this->publishedCount }}
        </div>
    </x-dashboard.analytic-card>

    <x-dashboard.analytic-card class="w-1/2 md:w-1/3">
        <div class="font-bold">
            Draft Posts
        </div>
        <div class="text-4xl text-purple-700 dark:text-purple-500 font-semibold">
            {{ $this->draftCount }}
        </div>
    </x-dashboard.analytic-card>
</div>
