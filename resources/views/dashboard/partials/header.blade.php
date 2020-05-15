<header class="flex-shrink-0 flex items-center justify-between bg-gray-100 dark:bg-gray-800 border-b border-gray-400 dark:border-gray-600 px-4 sm:px-6 space-x-6">
    <div class="flex-shrink-0 min-w-0 flex py-4">
        <button
            @click="sidebarOpen = true"
            class="lg:hidden text-gray-700 mr-4"
        >
            <span class="text-2xl fas fa-bars"></span>
        </button>
        <div class="flex-shrink-1">
            <h1 class="text-xl md:text-2xl font-semibold">
                @hasSection('view-title')
                    @yield('view-title')
                @else
                    @yield('title')
                @endif
            </h1>
        </div>
    </div>

    <div
        x-data="{ open: false }"
        class="flex-grow flex items-center justify-end"
    >
        {{-- Keep an "empty div" for Full Relative Width --}}
        <div>
            <button @click="open = true" class="w-full text-lg font-medium flex items-center focus:shadow-outline focus:outline-none">
                <img class="w-10 rounded-full" src="{{ Auth::user()->avatar }}" alt="Avatar of {{ Auth::user()->name }}">
                <span class="hidden md:inline w-full ml-1 py-4">
                    {{ Auth::user()->name }}
                </span>
            </button>

            <div class="relative">
                <div
                    x-cloak
                    x-show="open"
                    @click.away="open = false"
                    class="absolute z-50 top-0 right-0 min-w-full flex flex-col bg-gray-100 dark:bg-gray-700 border border-gray-400 dark:border-gray-600 rounded-lg shadow-xl overflow-hidden transform origin-top-right duration-75"

                    x-transition:enter="ease-out"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-90 scale-90"
                >
                    <span class="md:hidden w-full text-center p-4 border-b border-gray-400 dark:border-gray-600 whitespace-no-wrap">
                        {{ Auth::user()->name }}
                    </span>
                    <x-auth.logout />
                </div>
            </div>
        </div>
    </div>
</header>
