<header class="z-40 top-0 inset-x-0 w-full border-b border-gray-300 shadow">
    <nav class="container mx-auto px-4 py-2 flex items-center justify-between">
        <a href="{{ route('blog.index') }}" aria-label="Go to Blog's index Page"
           class="block text-black text-2xl font-bold"
        >
            {{ config('app.name') }}
        </a>

        <ul class="flex">
            @auth
                <li class="ml-4">
                    <a href="{{ route('dashboard.index') }}" aria-label="Go to Dashboard"
                       class="text-black border-b-2 border-transparent hover:border-blue-500 focus:border-blue-500"
                    >
                        Dashboard
                    </a>
                </li>
            @endauth
            <li class="ml-4">
                <a href="{{ route('blog.about') }}" aria-label="Go to my About page"
                   class="text-black border-b-2 border-transparent hover:border-blue-500 focus:border-blue-500"
                >
                    About
                </a>
            </li>
        </ul>
    </nav>
</header>
