<?php
/** @var Illuminate\Contracts\Pagination\LengthAwarePaginator|App\Post[] $posts */
?>

<div x-data class="h-full min-w-0 w-full">
    <div class="w-full md:px-4 py-4 md:px-6">
        <div class="w-full px-4 md:px-0 mb-4 flex items-center justify-between">
            {{-- Search box --}}
            <label class="w-1/2 sm:w-1/3 flex items-center bg-gray-100 dark:bg-gray-700 border border-gray-400 dark:border-gray-600 p-2 rounded-lg focus-within:shadow-outline transform duration-100">
                <input
                    type="text"
                    placeholder="Search a Post..."
                    wire:model.debounce.250ms="search"
                    class="flex-grow truncate bg-transparent focus:outline-none"
                    x-ref="search"
                    @keydown.ctrl.s.prevent.window="$refs.search.focus()"
                >
                <span class="flex-shrink-0 fas fa-search text-gray-500 dark:text-gray-400 mx-2"></span>
            </label>

            <div class="flex items-center justify-between">
                <a
                    role="button"
                    href="{{ route('dashboard.posts.create') }}"
                    class="hocus:text-gray-100 text-center bg-gray-100 dark:bg-gray-700 hocus:bg-blue-500 focus:shadow-outline focus:outline-none px-4 py-2 border border-gray-400 dark:border-gray-600 hocus:border-transparent rounded-lg transform duration-200"
                    x-ref="new"
                    @keydown.ctrl.p.prevent.window="$refs.new.click()"
                >
                    <span class="fas fa-plus mr-2"></span>
                    <span class="font-medium">New Post</span>
                </a>
            </div>
        </div>

        <div class="w-full bg-gray-100 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg">
            <div class="w-full flex items-center justify-end border-b border-gray-400 dark:border-gray-600 px-4 py-2">
                <x-dashboard.filters.menu>
                    <label class="w-full flex flex-col">
                        <span class="font-medium whitespace-no-wrap bg-gray-200 dark:bg-gray-800 px-4 py-2">
                            Trashed Posts
                        </span>
                        <div class="p-2">
                            <select
                                class="form-select flex-grow dark:bg-gray-700 border border-gray-400 dark:border-gray-600 rounded-lg focus:outline-none transform duration-100"
                                wire:model="trashed"
                            >
                                @foreach($trashedOptions as $value => $description)
                                    <option value="{{ $value }}">{{ $description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </label>
                </x-dashboard.filters.menu>
            </div>

            <div wire:loading class="w-full text-center text-gray-700 dark:text-gray-400 p-4">
                <span class="fas fa-sync-alt fa-4x fa-spin"></span>
            </div>

            <div wire:loading.remove class="w-full overflow-x-auto">
                @if(count($posts) < 1)
                    <div class="w-full text-center font-medium p-4">
                        Sin Resultados
                    </div>
                @else
                    <table class="min-w-full tracking-wide">
                    {{-- Table Head --}}
                    <thead class="text-gray-700 dark:text-gray-400 text-sm bg-gray-200 dark:bg-gray-900 font-semibold uppercase">
                    <tr class="border-b border-gray-400 dark:border-gray-600">
                        <th class="px-4 md:px-6 py-2 text-center">ID</th>
                        <th class="px-4 md:px-6 py-2 text-center">Status</th>
                        <th class="px-4 md:px-6 py-2 text-left">Title</th>
                        <th class="px-4 md:px-6 py-2 text-center"></th>
                    </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="font-medium">
                    @foreach($posts as $post)
                        <tr class="border-b-2 last:border-0 border-gray-200 dark:border-gray-700">
                            {{-- ID --}}
                            <td class="px-4 md:px-6 py-2 text-center">
                                {{-- TODO: Font Tabular Nums --}}
                                {{ $post->id }}
                            </td>

                            {{-- Status --}}
                            <td class="px-4 md:px-6 py-2 text-center">
                                @if($post->trashed())
                                    <span title="Trashed" class="fas fa-archive text-red-500"></span>
                                @elseif(!$post->published())
                                    <span title="Draft" class="fas fa-file-alt text-purple-500"></span>
                                @else
                                    <span title="Published" class="fas fa-check text-green-500"></span>
                                @endif
                            </td>

                            {{-- Title --}}
                            <td class="w-full max-w-xs md:max-w-sm xl:max-w-2xl px-4 md:px-6 py-2 truncate">
                                {{ $post->title }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 md:px-6 py-2 text-center text-gray-600 dark:text-gray-500 whitespace-no-wrap">
                                @if($post->trashed())
                                    <form action="{{ route('dashboard.posts.restore', $post) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <button
                                            type="submit"
                                            onclick="return confirm('Would you like to restore post \'{{ $post->title }}\'?')"
                                            class="hocus:text-yellow-600 focus:shadow-outline focus:outline-none transform duration-200 hocus:scale-150"
                                        >
                                            <span class="fas fa-trash-restore"></span>
                                        </button>
                                    </form>
                                @else
                                    <a class="inline-block align-middle hocus:text-blue-600 focus:shadow-outline focus:outline-none transform duration-200 hocus:scale-150 mx-2" href="{{ route('dashboard.posts.show', $post) }}">
                                        <span class="fas fa-eye"></span>
                                    </a>
                                    <a class="inline-block align-middle hocus:text-purple-600 focus:shadow-outline focus:outline-none transform duration-200 hocus:scale-150 mx-2" href="{{ route('dashboard.posts.edit', $post) }}">
                                        <span class="fas fa-pencil"></span>
                                    </a>
                                    <form class="inline-block align-middle mx-2" action="{{ route('dashboard.posts.destroy', $post) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button
                                            type="submit"
                                            onclick="return confirm('Are you sure you want to archive post \'{{ $post->title }}\'?')"
                                            class="hocus:text-red-700 focus:shadow-outline focus:outline-none transform duration-200 hocus:scale-150"
                                        >
                                            <span class="fas fa-archive"></span>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            @if(count($posts) > 0)
                <div class="w-full flex flex-col md:flex-row items-center justify-between border-t border-gray-400 dark:border-gray-600 px-4 py-2">
                    <span class="text-sm text-gray-700 dark:text-gray-400 font-medium mb-2 md:mb-0">
                        {{ $posts->firstItem() }}-{{ $posts->lastItem() }} of {{ $posts->total() }} results
                    </span>

                    {{ $posts->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
