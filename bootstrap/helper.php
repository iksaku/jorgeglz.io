<?php

use App\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

if (!function_exists('markdown')) {
    /**
     * @param string|Post $content
     * @param bool $inline
     * @return string
     */
    function markdown($content, bool $inline = false): string
    {
        if ($content instanceof Post) {
            $content = $content->content;
        }

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
}

if (!function_exists('markdown_cache_key')) {
    /**
     * @param string|Post $content
     * @return string
     */
    function markdown_cache_key($content): string
    {
        if ($content instanceof Post) {
            return $cacheKey = $content->slug;
        }

        return md5($content);
    }
}

if (!function_exists('emoji')) {
    /**
     * @param string $emoji
     * @return string
     */
    function emoji(string $emoji): string
    {
        if (empty(Cache::get('emoji'))) {
            Cache::forever('emoji', app('github')->emojis()->all());
        }

        return Cache::get('emoji')[$emoji] ?? null;
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
