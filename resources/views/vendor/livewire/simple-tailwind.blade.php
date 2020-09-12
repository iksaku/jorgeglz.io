<?php /* @var Illuminate\Contracts\Pagination\Paginator $paginator */ ?>
@if ($paginator->hasPages())
    <nav
        role="navigation"
        aria-label="Pagination Navigation"
        class="flex justify-evenly text-xl font-medium leading-5"
    >
        {{-- Previous Page Link --}}
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
                class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100 px-4 py-2 border border-gray-400 dark:border-gray-600 rounded-md focus:outline-none hocus:shadow-outline-blue cursor-pointer transition ease-in-out duration-150"
            >
                {!! __('pagination.previous') !!}
            </button>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <button
                wire:click="nextPage"
                wire:loading.attr="disabled"
                rel="next"
                class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100 px-4 py-2 border border-gray-400 dark:border-gray-600 rounded-md focus:outline-none hocus:shadow-outline-blue cursor-pointer transition ease-in-out duration-150"
            >
                {!! __('pagination.next') !!}
            </button>
        @else
            <span
                class="inline-flex items-center bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300 px-4 py-2 border border-gray-400 dark:border-gray-600 rounded-md cursor-not-allowed opacity-75"
            >
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
