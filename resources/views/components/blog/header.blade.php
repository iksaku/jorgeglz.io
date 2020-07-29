<header class="w-full bg-gray-100 dark:bg-gray-800 border-b border-gray-400 dark:border-gray-600">
    <nav class="container mx-auto px-4 py-2 flex items-center justify-between">
        <a
            class="text-2xl font-bold focus:shadow-outline focus:outline-none"
            href="{{ route('blog.index') }}"
            aria-label="Go to Blog's index Page"
        >
            {{ config('app.name') }}
        </a>

        <ul class="flex">
            @auth
                <x-blog.header.link route="dashboard.index" label="Go to Dashboard">
                    Dashboard
                </x-blog.header.link>
            @endauth

            <x-blog.header.link route="blog.about" label="Go to my About page">
                About
            </x-blog.header.link>
        </ul>
    </nav>
</header>
