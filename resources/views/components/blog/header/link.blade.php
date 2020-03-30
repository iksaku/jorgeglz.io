@props(['route', 'label'])

<li class="ml-4">
    <a href="{{ route($route) }}" aria-label="{{ $label }}"
       class="text-black border-b-2 border-transparent hocus:border-blue-500 @route($route) border-blue-500 @endif"
    >
        {{ $slot }}
    </a>
</li>
