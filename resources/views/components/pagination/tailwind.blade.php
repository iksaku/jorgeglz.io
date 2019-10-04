<?php /** @var Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */ ?>

@if ($paginator->hasPages())
    <nav class="my-4">
        <ul class="flex items-center justify-between">
            {{-- Previous Page Link --}}
            <li
                class="w-1/2 mr-2 md:w-1/12"
                aria-label="@lang('pagination.previous')"
                @if ($paginator->onFirstPage())
                    aria-disabled="true"
                @else
                    rel="prev"
                @endif
            >
                <button
                    class="pagination control px-2 md:px-4"
                    @if($paginator->onFirstPage())
                        disabled
                    @else
                        onclick="window.location.href = '{{ $paginator->previousPageUrl() }}'"
                    @endif
                >
                    <span class="inline-block">&lt;</span>
                    <span class="inline-block whitespace-no-wrap font-normal md:hidden">
                        Previous Page
                    </span>
                </button>
            </li>

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                 {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="hidden mx-2 w-1/12 cursor-default md:block" aria-disabled="true">
                        <span class="w-full py-2 flex items-center justify-center">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                 {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li
                            class="hidden mx-2 w-1/12 md:block"
                            @if($page === $paginator->currentPage())
                                aria-current="page"
                            @endif
                        >
                            <button
                                class="pagination page flex items-center justify-center"
                                @if($page === $paginator->currentPage())
                                    disabled
                                @else
                                    onclick="window.location.href = '{{ $url }}'"
                                @endif
                            >
                                {{ $page }}
                            </button>
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            <li
                class="w-1/2 mr-2 md:w-1/12"
                aria-label="@lang('pagination.previous')"
                @if (!$paginator->hasMorePages())
                    aria-disabled="true"
                @else
                    rel="next"
                @endif
            >
                <button
                    class="pagination control px-2 md:px-4"
                    @if(!$paginator->hasMorePages())
                        disabled
                    @else
                        onclick="window.location.href = '{{ $paginator->nextPageUrl() }}'"
                    @endif
                >
                    <span class="inline-block whitespace-no-wrap font-normal md:hidden">
                        Next Page
                    </span>
                    <span class="inline-block">&gt;</span>
                </button>
            </li>
        </ul>
    </nav>
@endif
