<header class="flex-shrink-0 text-gray-300 bg-gray-900 px-4 sm:px-6 shadow-md flex items-center justify-between">
    <div class="flex-1 min-w-0 flex py-4">
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
        class="ml-6 flex-grow text-lg font-medium flex items-center justify-end"
    >
        <div>
            <button @click="open = true" class="w-full text-lg flex items-center focus:shadow-outline focus:outline-none">
                <img class="w-10 rounded-full" src="{{ Auth::user()->avatar }}" alt="Avatar of {{ Auth::user()->name }}">
                <span class="hidden md:inline w-full ml-1 py-4">
                    {{ Auth::user()->name }}
                </span>
            </button>

            <div class="relative min-w-full">
                <div
                    x-cloak
                    x-show="open"
                    @click.away="open = false"
                    class="absolute z-50 top-0 right-0 flex flex-col text-gray-900 bg-gray-100 border border-gray-400 rounded-lg shadow-xl mt-1 overflow-hidden transform origin-top-right duration-75"

                    x-transition:enter="ease-out"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-90 scale-90"
                >
                    <span class="md:hidden w-full text-center p-4 border-b whitespace-no-wrap">
                        {{ Auth::user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf

                        <button class="w-full hocus:text-gray-100 hocus:bg-red-700 focus:outline-none px-4 py-2 transform duration-200" type="submit">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
