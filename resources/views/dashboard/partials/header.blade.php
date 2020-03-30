<header class="flex-shrink-0 text-gray-300 bg-gray-900 px-4 sm:px-6 py-4 shadow-md flex items-center justify-between">
    <div class="flex-1 min-w-0 flex">
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

        <div class="ml-6 flex-grow text-lg font-medium flex items-center justify-end">
            <div class="hidden md:block">
                <span class="mr-4">
                    {{ Auth::user()->name }}
                </span>

                <form class="inline-block" action="{{ route('logout') }}" method="post">
                    @csrf

                    <button class="hocus:bg-red-700 focus:shadow-outline focus:outline-none px-4 py-2 -my-2 rounded-lg transform duration-200" type="submit">
                        Logout
                    </button>
                </form>
            </div>
            <div x-data="{ open: false }" class="md:hidden flex items-end justify-end">
                <button @click="open = true" class="text-lg focus:shadow-outline focus:outline-none">
                    <span class="fas fa-user"></span>
                </button>

                <div class="relative min-w-full">
                    <div
                        x-cloak
                        x-show="open"
                        @click.away="open = false"
                        class="absolute z-50 top-0 right-0 flex flex-col text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-lg mt-1 overflow-hidden transform origin-top-right duration-75"

                        x-transition:enter="ease-in"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="ease-out"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-90 scale-90"
                    >
                        <span class="w-full text-center p-4 border-b whitespace-no-wrap">
                            {{ Auth::user()->name }}
                        </span>
                        <form class="inline-block w-full" action="{{ route('logout') }}" method="post">
                            @csrf

                            <button class="w-full hocus:text-gray-100 hocus:bg-red-700 focus:outline-none px-4 py-2 transform duration-200" type="submit">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
