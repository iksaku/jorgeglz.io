@props(['route', 'highlight'])

<div class="-mx-3">
    <a
        class="px-3 py-2 flex items-center justify-between hocus:text-gray-100 hocus:bg-gray-700 focus:shadow-outline focus:outline-none rounded-lg transform duration-200 @route($highlight ?? $route) text-gray-100 font-semibold bg-gray-700 @endif"
        href="{{ route($route) }}"
    >
        {{ $slot }}
    </a>
</div>
