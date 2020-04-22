<?php /** @var Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */ ?>

@if ($paginator->hasPages())
    <nav class="bg-gray-100 dark:bg-gray-800 border border-gray-400 dark:border-gray-600 rounded-lg overflow-hidden">
        <ul class="flex">
            {{-- Previous Page --}}
            <li
                aria-label="@lang('pagination.previous')"
                @if ($paginator->onFirstPage())
                    aria-disabled="true"
                @else
                    rel="prev"
                @endif
            >
                <x-pagination.button
                    class="space-x-2"
                    type="control"
                    :disabled="$paginator->onFirstPage()"
                    wireClick="previousPage"
                >
                    &lt;
                    <span class="md:hidden">Previous Page</span>
                </x-pagination.button>
            </li>

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    {{-- Separator (Three dots) --}}
                    <li class="hidden md:block cursor-default" aria-disabled="true">
                        <span class="h-full flex items-center justify-center font-medium border-r px-3 py-1">
                            {{ $element }}
                        </span>
                    </li>
                @elseif (is_array($element))
                    {{-- Array of Links --}}
                    @foreach ($element as $page => $url)
                        <li
                            class="hidden md:block"
                            @if ($page === $paginator->currentPage()) aria-current="page" @endif
                        >
                            <x-pagination.button
                                type="page"
                                :disabled="$page === $paginator->currentPage()"
                                :wireClick="'gotoPage(' . $page . ')'"
                            >
                                {{ $page }}
                            </x-pagination.button>
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page --}}
            <li
                aria-label="@lang('pagination.next')"
                @if(!$paginator->hasMorePages())
                    aria-disabled="true"
                @else
                    rel="next"
                @endif
            >
                <x-pagination.button
                    class="border-none space-x-2"
                    type="control"
                    :disabled="!$paginator->hasMorePages()"
                    wireClick="nextPage"
                >
                    <span class="md:hidden">Next Page</span>
                    &gt;
                </x-pagination.button>
            </li>
        </ul>
    </nav>
@endif
