@props(['route', 'label'])

<li class="mr-4 last:ml-0">
    <a
        class="border-b-2 border-transparent hover:border-blue-500 focus:shadow-outline focus:outline-none @route($route) border-blue-500 @endroute"
        href="{{ route($route) }}"
        aria-label="{{ $label }}"
    >
        {{ $slot }}
    </a>
</li>
