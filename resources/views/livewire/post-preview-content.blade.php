<div
    x-cloak
    x-data="{ tab: 'edit' }"
    class="bg-gray-100 border rounded-lg shadow overflow-hidden"
>
    {{-- Tabs --}}
    <div class="bg-gray-300 flex items-center p-2 pb-0">
        <button
            class="text-gray-700 text-sm font-medium focus:shadow-outline focus:outline-none px-4 pt-2 pb-1 mr-1 rounded-t-lg transform duration-200"
            :class="tab === 'edit' ? 'bg-gray-100 font-semibold' : ''"
            @click.prevent="tab = 'edit'"
        >
            Edit
        </button>

        <button
            class="text-gray-700 text-sm font-medium focus:shadow-outline focus:outline-none px-4 pt-2 pb-1 rounded-t-lg transform duration-200"
            :class="tab === 'preview' ? 'bg-gray-100 font-semibold' : ''"
            @click.prevent="tab = 'preview'"
        >
            Preview
        </button>
    </div>

    {{-- Edit Tab --}}
    <div x-show="tab === 'edit'" class="p-4">
        <label>
            <textarea
                required
                name="content"
                placeholder="Make those small things unforgettable!"
                wire:model.lazy="content"
                class="h-full w-full bg-transparent focus:shadow-outline resize-none"
                rows="10"
            ></textarea>
            <x-input-error property="content" />
        </label>
    </div>

    {{-- Preview Tab --}}
    <div x-show="tab === 'preview'" class="p-4">
        <div wire:loading>
            Loading...
        </div>
        <article class="markdown" wire:loading.remove>
            {!! $this->renderedContent !!}
        </article>
    </div>
</div>
