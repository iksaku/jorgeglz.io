<div x-data="{ open: false }" class="flex-shrink-0">
    <button
        @click="open = !open"
        class="flex items-center text-gray-700 bg-gray-200 px-4 py-2 border rounded-lg focus:shadow-outline focus:outline-none"
    >
        <span class="fas fa-filter mr-2"></span>
        <span class="align-middle fas fa-angle-down"></span>
    </button>

    <div class="relative min-w-full">
        <div
            x-cloak
            x-show="open"
            @click.away="open = false"
            class="absolute z-20 top-0 right-0 flex flex-col text-gray-900 bg-white border border-gray-400 rounded-lg shadow-xl mt-1 overflow-x-hidden"

            x-transition:enter="transform origin-top-right duration-75 ease-out"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transform origin-top-right duration-75 ease-in"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-90 scale-90"
        >
            {{ $slot }}
        </div>
    </div>
</div>
