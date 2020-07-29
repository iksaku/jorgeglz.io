<footer class="w-full bg-gray-100 dark:bg-gray-800 border-t border-gray-400 dark:border-gray-600">
    <div class="container flex items-center justify-between px-4 mx-auto">
        <section class="text-sm md:text-base font-bold py-4">
            &copy; 2019 - {{ date('Y') }} Jorge González
        </section>

        <ul class="flex text-xl md:text-2xl space-x-4 sm:space-x-8">
            @foreach(config('social') as $name => $data)
                <li>
                    <a
                        href="{{ $data['url'] }}"
                        target="_blank"
                        rel="noreferrer"
                        title="Go to my {{ $data['name'] ?? ucwords($name) }} profile"
                        aria-label="Go to my {{ $data['name'] ?? ucwords($name) }} profile"
                    >
                        <span class="fab fa-{{ $name }}"></span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</footer>
