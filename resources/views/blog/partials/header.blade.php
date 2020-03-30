<header class="z-40 top-0 inset-x-0 w-full border-b border-gray-300 shadow">
    <nav class="container mx-auto px-4 py-2 flex items-center justify-between">
        <a href="{{ route('blog.index') }}" aria-label="Go to Blog's index Page"
           class="block text-black text-2xl font-bold"
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
