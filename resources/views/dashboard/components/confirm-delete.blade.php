@push('modals')
    {{-- TODO: Use global Alpine x-data which manages more than one modal --}}
    {{-- Refer to https://github.com/alpinejs/alpine/issues/49 --}}

    <div
        x-data="{ isOpen: false }"
        x-show="isOpen"
        class="fixed z-50 inset-0 relative"
    >
        <div class="absolute inset-0 bg-black opacity-25" @click="isOpen = false"></div>

        <div class="">
            {{ $slot }}
        </div>
    </div>
@endpush
