<?php

use App\Post;

if (!function_exists('markdown')) {
    /**
     * @param string|Post $content
     * @param bool $inline
     * @return string
     */
    function markdown($content, bool $inline = false): string
    {
        $cacheKey = markdown_cache_key($content, $inline);

        if ($content instanceof Post) {
            $post = $content;
            $content = $post->content;
        }

        return Cache::tags('markdown')->remember($cacheKey, now()->addDay(), function () use ($content, $inline) {
            $parser = app('markdown');

            if ($inline) return $parser->convertToInlineHtml($content);

            return $parser->convertToHtml($content);
        });
    }
}

if (!function_exists('markdown_cache_key')) {
    /**
     * @param string|Post $content
     * @param bool $inline
     * @return string
     */
    function markdown_cache_key($content, bool $inline): string
    {
        if ($content instanceof Post) {
            $key = 'post:'.$content->slug;
        } else {
            $key = md5($content);
        }

        if ($inline) {
            $key .= ':inline';
        }

        return $key;
    }
}

if (!function_exists('app_title')) {
    /**
     * @return string
     */
    function app_title(): string
    {
        $prefix = '';

        if (View::hasSection('title')) {
            $prefix = View::getSection('title').' | ';
        }

        return $prefix.config('app.name');
    }
}
