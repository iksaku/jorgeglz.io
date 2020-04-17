<?php /** @var Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */ ?>

@if ($paginator->hasPages())
    <nav class="text-gray-700 bg-white border border-gray-400 rounded-lg overflow-hidden">
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
                <x-dashboard.pagination.button
                    type="control"
                    :disabled="$paginator->onFirstPage()"
                    wireClick="previousPage"
                >
                    &lt;
                    <span class="md:hidden ml-2">Previous Page</span>
                </x-dashboard.pagination.button>
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
                            <x-dashboard.pagination.button
                                type="page"
                                :disabled="$page === $paginator->currentPage()"
                                :wireClick="'gotoPage(' . $page . ')'"
                            >
                                {{ $page }}
                            </x-dashboard.pagination.button>
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
                <x-dashboard.pagination.button
                    class="border-none"
                    type="control"
                    :disabled="!$paginator->hasMorePages()"
                    wireClick="nextPage"
                >
                    <span class="md:hidden mr-2">Next Page</span>
                    &gt;
                </x-dashboard.pagination.button>
            </li>
        </ul>
    </nav>
@endif
