<header class="flex-shrink-0 text-gray-300 bg-gray-900 px-4 sm:px-6 py-4 shadow-md flex items-center justify-between">
    <div class="flex-1 min-w-0 flex">
        <button
            @click="sidebarOpen = true"
            class="lg:hidden text-gray-700"
        >
            <span class="text-2xl fas fa-bars"></span>
        </button>
        <div class="flex-shrink-1 ml-4 lg:ml-0">
            <h1 class="text-xl md:text-2xl font-semibold">
                @yield('title')
            </h1>
        </div>

        <div class="ml-6 flex-shrink-0 flex items-center">
            {{-- TODO: Account Dropdown --}}
        </div>
    </div>
</header>
