@props(['name' => null, 'og' => null, 'content'])

@push('meta')
    <meta
        @isset($name) name="{{ $name }}" @endisset
        @isset($og) property="og:{{ $og }}" @endisset
        content="{{ $content }}"
    >
@endpush
