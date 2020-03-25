<div
    x-cloak
    x-show="sidebarOpen"
    @click="sidebarOpen = false"
    class="lg:hidden fixed inset-0 bg-black opacity-25"
></div>

<div
    x-ref="sidebar"
    class="fixed lg:sticky z-50 inset-y-0 left-0 w-64 text-gray-300 bg-gray-800 overflow-y-auto transform -translate-x-full lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0 duration-200 ease-out' : '-translate-x-full duration-200 ease-in'"
>
    <div class="bg-gray-900 px-8 py-4 shadow-md flex items-center justify-between">
        <h2 class="flex-grow md:text-center text-xl md:text-2xl font-semibold">
            {{ config('app.name') }}
        </h2>
        <button
            @click="sidebarOpen = false"
            class="lg:hidden"
        >
            <span class="text-2xl fas fa-times"></span>
        </button>
    </div>

    <nav class="font-medium px-8 py-4">
        <div class="mb-8 -mx-3">
            <a
                class="px-3 py-2 flex items-center justify-between hocus:text-gray-100 hocus:font-semibold hocus:bg-gray-700 rounded-lg @route('dashboard.index') text-gray-100 font-semibold bg-gray-700 @endroute"
                href="{{ route('dashboard.index') }}"
            >
                <span class="">@lang('Dashboard')</span>
            </a>
        </div>

        <div class="mb-8">
            <h3 class="text-xs text-gray-500 uppercase tracking-wide mb-2">
                @lang('Resources')
            </h3>
            <div class="-mx-3">
                <a
                    class="px-3 py-2 flex items-center justify-between hocus:text-gray-100 hocus:font-semibold hocus:bg-gray-700 rounded-lg @route('dashboard.posts') text-gray-100 font-semibold bg-gray-700 @endroute"
                    href="{{ route('dashboard.posts.index') }}"
                >
                    <span class="">@lang('Posts')</span>
                </a>
            </div>
        </div>
    </nav>
</div>
