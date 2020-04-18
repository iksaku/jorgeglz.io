@props(['route', 'label'])

<li class="mr-4 last:ml-0">
    <a href="{{ route($route) }}" aria-label="{{ $label }}"
       class="text-black border-b-2 border-transparent hover:border-blue-500 focus:shadow-outline focus:outline-none @route($route) border-blue-500 @endif"
    >
        {{ $slot }}
    </a>
</li>
