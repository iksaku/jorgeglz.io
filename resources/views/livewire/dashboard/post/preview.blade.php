<div
    x-cloak
    x-data="{ tab: 'edit' }"
    class="bg-gray-100 dark:bg-gray-800 border border-gray-400 dark:border-gray-600 md:rounded-lg overflow-hidden"
>
    {{-- Tabs --}}
    <div class="tab-row bg-gray-300 dark:bg-gray-900 flex items-center border-gray-400 dark:border-gray-600 p-2 pb-0">
        <button
            class="focus:outline-none text-sm font-medium px-3 py-2 rounded-t-lg transform duration-200"
            :class="tab === 'edit' ? 'bg-gray-100 dark:bg-gray-800 selected' : 'text-gray-700 dark:text-gray-400'"
            @click.prevent="tab = 'edit'"
        >
            Write
        </button>

        <button
            class="focus:outline-none text-sm font-medium px-3 py-2 rounded-t-lg transform duration-200"
            :class="tab === 'preview' ? 'bg-gray-100 dark:bg-gray-800 selected' : 'text-gray-700 dark:text-gray-400'"
            @click.prevent="tab = 'preview'"
        >
            Preview
        </button>
    </div>

    {{-- Edit Tab --}}
    <div x-show="tab === 'edit'" class="p-2">
        <label>
            <textarea
                name="content"
                placeholder="Make those small things unforgettable!"
                wire:model.lazy="content"
                class="h-full w-full bg-transparent rounded p-2 focus:shadow-outline @error('content') border border-red-500 @enderror"
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
