@props(['type', 'disabled' => false, 'href' => null, 'wireClick' => null])

@php
$class = 'flex items-center justify-center font-medium px-4 py-2 focus:outline-none transition-colors duration-100';

if (!$disabled) {
    $class .= ' hocus:text-gray-100 hocus:bg-blue-500 hocus:border-transparent border-r';
} else {
    $class .= 'cursor-not-allowed';

    if ($type === 'control' ) {
        $class .= ' bg-gray-400 opacity-75';
    } elseif ($type === 'page') {
        $class .= ' text-gray-100 bg-blue-500';
    }
}
@endphp

<button
    {{ $attributes->merge(compact('class')) }}
    @if($disabled)
        disabled
    @elseif($href)
        onclick="window.location.href = '{{ $href }}'"
    @elseif($wireClick)
        wire:click.prevent="{{ $wireClick }}"
    @endif
>
    {{ $slot }}
</button>
