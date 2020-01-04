<?php

namespace App\CommonMark;

use League\CommonMark\Converter as CommonMarkConverter;

class Converter extends CommonMarkConverter
{
    public function convertToInlineHtml(string $commonMark): string
    {
        // If excerpt, trim all following text (including excerpt)
        $commonMark = preg_replace(
            '/[.\s]*<!--[ ]*excerpt[ ]*-->[\s\S]+/i',
            '',
            $commonMark,
            -1,
            $count
        );

        if ($count < 1) {
            // Select the first 256 characters (and following until first empty character) and trim the rest.
            $commonMark = preg_replace('/([\s\S]{256}\S+)[\s\S]+/i',
                '$1',
                $commonMark
            );
        }

        // Remove line breaks from text
        $commonMark = preg_replace('/[\r\n]+/', ' ', $commonMark);

        return preg_replace(
            ['#<p>(.*)</p>#i', '/[\s,.]+$/m'],
            ['$1 ', ''],
            $this->convertToHtml($commonMark)
        );
    }
}
