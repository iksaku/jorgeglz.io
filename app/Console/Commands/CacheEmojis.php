<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CacheEmojis extends Command
{
    const ZERO_WIDTH_JOINER = "\u{200D}";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emoji';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches Github Emoji Codes';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->comment('Fetching emoji codes from Github...');
        $emoji = app('github')->emojis()->all();

        $this->comment('Caching emoji codes...');
        foreach ($emoji as $code => $url) {
            if (preg_match('/^((?!unicode).)*$/', $url)) {
                // Custom Github emoji
                continue;
            }

            preg_match('/(?<=\/)[a-zA-Z0-9\-]+(?=\.png)/', $url, $matches);
            $parts = array_map(
                fn (string $part) => mb_chr(hexdec($part)),
                explode('-', $matches[0])
            );

            $unicode = implode(self::ZERO_WIDTH_JOINER, $parts);

            Cache::tags('emoji')->forever($code, $unicode);
        }

        Cache::tags('control')->forever('emoji', true);

        $this->info('Cached all emoji codes from Github!');
    }
}
