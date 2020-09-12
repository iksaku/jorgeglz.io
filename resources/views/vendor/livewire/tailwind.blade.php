<?php /* @var Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */ ?>

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300 px-4 py-2 border border-gray-400 dark:border-gray-600 rounded-md cursor-not-allowed opacity-50"
                >
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <button
                    wire:click="previousPage"
                    wire:loading.attr="disabled"
                    rel="prev"
                    class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100 px-4 py-2 border border-gray-400 dark:border-gray-600 rounded-md focus:outline-none cursor-pointer transition ease-in-out duration-150"
                >
                    {!! __('pagination.previous') !!}
                </button>
            @endif

            @if ($paginator->hasMorePages())
                <button
                    wire:click="nextPage"
                    wire:loading.attr="disabled"
                    rel="next"
                    class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100 px-4 py-2 border border-gray-400 dark:border-gray-600 rounded-md focus:outline-none cursor-pointer transition ease-in-out duration-150"
                >
                    {!! __('pagination.next') !!}
                </button>
            @else
                <span
                    class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300 px-4 py-2 border border-gray-400 dark:border-gray-600 rounded-md cursor-not-allowed opacity-50"
                >
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div class="flex-shrink-0">
                <p class="text-sm text-gray-700 dark:text-gray-100 leading-5">
                    {!! __('Showing') !!}
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex items-center shadow-sm border border-gray-400 dark:border-gray-600 divide-x divide-gray-400 dark:divide-gray-600 rounded-md overflow-x-hidden">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span
                                class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300 px-4 py-2 cursor-not-allowed opacity-50"
                                aria-hidden="true"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <button
                            wire:click="previousPage"
                            rel="prev"
                            aria-label="{{ __('pagination.previous') }}"
                            class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100 px-4 py-2 focus:outline-none cursor-pointer transition ease-in-out duration-150"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300 px-4 py-2 cursor-not-allowed opacity-50"
                                >
                                    {{ $element }}
                                </span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300 px-4 py-2 cursor-not-allowed opacity-50"
                                        >
                                            {{ $page }}
                                        </span>
                                    </span>
                                @else
                                    <button
                                        wire:click="gotoPage({{ $page }})"
                                        aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                        class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100 px-4 py-2 focus:outline-none cursor-pointer transition ease-in-out duration-150"
                                    >
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <button
                            wire:click="nextPage"
                            rel="next"
                            aria-label="{{ __('pagination.next') }}"
                            class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100 px-4 py-2 focus:outline-none cursor-pointer transition ease-in-out duration-150"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span
                                class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300 px-4 py-2 cursor-not-allowed opacity-50"
                                aria-hidden="true"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
