<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use IntlChar;

class CacheEmojis extends Command
{
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
        $emojis = app('github')->emojis()->all();

        $this->comment('Caching emojis...');
        foreach ($emojis as $code => $url) {
            if (preg_match('/^((?!unicode).)*$/', $url)) {
                // Custom Github emoji
                continue;
            }

            preg_match('/(?<=\/)[a-zA-Z0-9\-]+(?=\.png)/', $url, $matches);
            $parts = explode('-', $matches[0]);

            $unicode = '';
            foreach ($parts as $part) {
                $unicode .= IntlChar::chr(hexdec($part));
            }

            Cache::tags('emoji')->forever($code, $unicode);
        }

        $this->info('Cached all emojis!');
    }
}
