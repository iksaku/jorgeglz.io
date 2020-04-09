<div class="h-full min-w-0 w-full">
    <div class="w-full p-4 md:px-6">
        <div class="w-full mb-4 flex items-center justify-between">
            {{-- Search box --}}
            <label class="w-1/2 sm:w-1/3 text-gray-900 bg-white p-2 border border-gray-400 rounded-lg focus-within:shadow-outline">
                <input
                    type="text"
                    placeholder="Search a Post..."
                    wire:model.debounce="search"
                    class="w-full block truncate bg-transparent focus:outline-none"
                >
            </label>

            <div class="flex items-center justify-between">
                <a
                    role="button"
                    href="{{ route('dashboard.posts.create') }}"
                    class="text-gray-700 hocus:text-gray-100 text-center bg-white hocus:bg-blue-500 focus:shadow-outline focus:outline-none px-4 py-2 border border-gray-400 hocus:border-transparent rounded-lg transform duration-200"
                >
                    <span class="fas fa-plus mr-2"></span>
                    <span class="font-medium">New Post</span>
                </a>
            </div>
        </div>

        <div class="-mx-4 md:mx-0 md:rounded-lg border border-t-0 shadow">
            <div class="w-full flex items-center justify-end bg-gray-100 md:rounded-t-lg px-4 md:px-6 py-2">
                <x-dashboard.filters.menu>
                    <label class="w-full flex flex-col">
                        <span class="bg-gray-200 font-medium px-4 py-2 whitespace-no-wrap">
                            Trashed Posts
                        </span>
                        <div class="p-2">
                            <select
                                class="form-select flex-grow rounded-lg"
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

            <div class="relative w-full md:rounded-b-lg overflow-x-auto">
                <div wire:loading class="absolute inset-0">
                    <div class="relative h-full w-full">
                        <div class="absolute inset-0 bg-black opacity-25"></div>
                        <div class="absolute inset-0 flex z-10 items-center justify-center">
                            <span class="fas fa-sync-alt text-white fa-4x fa-spin">
                            </span>
                        </div>
                    </div>
                </div>

                <table class="min-w-full tracking-wide rounded-b-lg">
                    {{-- Table Head --}}
                    <thead class="text-gray-700 text-sm bg-gray-200 font-semibold uppercase">
                    <tr class="border-b border-gray-200">
                        <th class="px-4 md:px-6 py-2 text-center">ID</th>
                        <th class="px-4 md:px-6 py-2 text-center">Status</th>
                        <th class="px-4 md:px-6 py-2 text-left">Title</th>
                        <th class="px-4 md:px-6 py-2 text-center"></th>
                    </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="font-medium text-gray-800 bg-white">
                    @foreach($this->posts as $post)
                        <tr class="border-b-2 last:border-0 border-gray-200">
                            {{-- ID --}}
                            <td class="px-4 md:px-6 py-2 text-center">
                                {{-- Font Tabular Nums --}}
                                {{ $post->id }}
                            </td>

                            {{-- Status --}}
                            <td class="px-4 md:px-6 py-2 text-center">
                                @if($post->trashed())
                                    <span title="Trashed" class="fas fa-archive text-red-500"></span>
                                @elseif(!$post->published)
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
                            <td class="px-4 md:px-6 py-2 text-center text-gray-600 whitespace-no-wrap">
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
                                    <a class="inline-block align-middle hocus:text-indigo-700 focus:shadow-outline focus:outline-none transform duration-200 hocus:scale-150 mx-2" href="{{ route('dashboard.posts.show', $post) }}">
                                        <span class="fas fa-eye"></span>
                                    </a>
                                    <a class="inline-block align-middle hocus:text-indigo-700 focus:shadow-outline focus:outline-none transform duration-200 hocus:scale-150 mx-2" href="{{ route('dashboard.posts.edit', $post) }}">
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
            </div>
        </div>

        {{ $this->posts->onEachSide(2)->links() }}
    </div>
</div>
