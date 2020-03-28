@props(['route'])

<div class="-mx-3">
    <a
        class="px-3 py-2 flex items-center justify-between hocus:text-gray-100 hocus:bg-gray-700 focus:outline-none rounded-lg transform duration-200 @route($route) text-gray-100 font-semibold bg-gray-700 @endroute"
        href="{{ route($route) }}"
    >
        {{ $slot }}
    </a>
</div>
