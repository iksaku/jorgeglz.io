<?php

use App\Markdown\CacheableInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if (!function_exists('markdown')) {
    /**
     * @param CacheableInterface $cacheable
     * @param bool $inline
     * @param bool $cache
     * @return string
     */
    function markdown(CacheableInterface $cacheable, bool $inline = false, bool $cache = true): string
    {
        $cacheTags = ['markdown'];
        if ($inline) $cacheTags[] = 'inline';

        return trim(Cache::tags($cacheTags)->remember(
            $cacheable->getCacheKey(),
            $cache ? now()->addWeek() : 0,
            function() use ($cacheable, $inline) {
                $content = $cacheable->getContent();

                if ($inline) {
                    $converter = app('markdown.inline');

                    $content = preg_replace(
                        ['/([\s\S]{256}\S+)[\s\S]+/i', '/[\r\n]+/', '/[\s,.]+$/m'],
                        ['$1', ' ', ''],
                        $content
                    );
                } else {
                    $converter = app('markdown');
                }

                return $converter->convertToHtml($content);
            }
        ));
    }
}

if (!function_exists('emoji')) {
    /**
     * @param string $emoji
     * @return string|null
     */
    function emoji(string $emoji): ?string
    {
        if (!Cache::tags('control')->get('emoji', false)) {
            Artisan::call('emoji');
        }

        return Cache::tags('emoji')->get($emoji);
    }
}

if (!function_exists('in_route')) {
    /**
     * @param string $route
     * @return bool
     */
    function in_route(string $route): bool
    {
        return Str::contains(Route::currentRouteName(), $route);
    }
}

if (!function_exists('avatar')) {
    /**
     * @param string $email
     * @return string
     */
    function avatar (string $email): string
    {
        return 'https://secure.gravatar.com/avatar/'.md5(strtolower(trim($email)));
    }
}
