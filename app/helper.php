<?php

if (!function_exists('markdown')) {
    /**
     * @param string $content
     * @param bool $inline
     * @return string
     */
    function markdown(string $content, bool $inline = false)
    {
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
        }

        return preg_replace_callback(
            '/:([\w\d+-]+):/m',
            function ($shortcuts) {
                return github_emoji($shortcuts[1]) ?? $shortcuts[1];
            },
            parsedown($content, $inline)
        );
    }
}

if (!function_exists('github_emoji')) {
    /**
     * @param string $shortcut
     * @return string|null
     */
    function github_emoji(string $shortcut)
    {
        /** @var string[] $emoji */
        $emoji = json_decode(
            file_get_contents(base_path('resources/emoji.json')),
            true
        );

        if ($url = $emoji[$shortcut]) {
            return "<img class='emoji' alt='$shortcut' src='$url'>";
        }

        return null;
    }
}
