<footer class="z-40 bottom-0 inset-x-0 w-full bg-white dark:bg-gray-800 border-t border-gray-400 dark:border-gray-600">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <section class="text-sm md:text-base font-bold py-4">
            &copy; {{ date('Y') }} Jorge González
        </section>

        <ul class="flex text-xl md:text-2xl">
            @foreach(config('social') as $name => $data)
                <li class="ml-4 sm:ml-8">
                    <a
                        href="{{ $data['url'] }}"
                        aria-label="Open Jorge's {{ $data['name'] ?? ucwords($name) }} profile"
                        target="_blank"
                        rel="noreferrer"
                    >
                        <span class="fab fa-{{ $name }}"></span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</footer>
