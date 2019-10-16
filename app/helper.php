<?php

use App\Post;

if (!function_exists('markdown')) {
    /**
     * @param Post|string $content
     * @param bool $inline
     * @param string|null $cacheKey
     * @return string
     */
    function markdown($content, bool $inline = false, string $cacheKey = null): string
    {
        if (empty($cacheKey)) {
            if ($content instanceof Post) {
                /** @var Post $post */
                $post = $content;

                $content = $post->content;
                $cacheKey = 'post:'.$post->slug;
            } else {
                $cacheKey = 'route:'.Route::currentRouteName().':'.strlen($content);
            }
        }

        if ($inline) {
            $cacheKey .= ':inline';
        }

        return Cache::tags('markdown')->rememberForever($cacheKey, function () use ($content, $inline) {
            if ($inline) {
                $content = preg_replace(
                    '/[.\s]*<!--[ ]*excerpt[ ]*-->[\s\S]+/i',
                    '',
                    $content,
                    -1,
                    $count
                );

                if ($count < 1) {
                    $content = substr($content, 0, 256);
                }
            } else {
                $content = preg_replace(
                    '/[.\s]?<!--[ ]*excerpt[ ]*-->/i',
                    '',
                    $content
                );
            }

            return preg_replace_callback(
                '/:([\w\d+-]+):/m',
                function ($shortcuts) {
                    return github_emoji($shortcuts[1]) ?? $shortcuts[1];
                },
                parsedown($content, $inline)
            );
        });
    }
}

if (!function_exists('github_emoji')) {
    /**
     * @param string $shortcut
     * @return string|null
     */
    function github_emoji(string $shortcut): string
    {
        return Cache::tags('emoji')->rememberForever($shortcut, function () use ($shortcut) {
            /** @var string[] $emoji */
            $emoji = json_decode(
                file_get_contents(base_path('resources/emoji.json')),
                true
            );

            if ($url = $emoji[$shortcut]) {
                return "<img class='emoji' alt='$shortcut' src='$url' draggable='false'>";
            }
        });
    }
}
