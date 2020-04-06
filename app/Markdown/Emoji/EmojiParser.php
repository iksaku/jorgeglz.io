<?php

namespace App\Markdown\Emoji;

use Illuminate\Support\Facades\Cache;
use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\InlineParserContext;

class EmojiParser implements InlineParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCharacters(): array
    {
        return [':'];
    }

    /**
     * {@inheritdoc}
     */
    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $previousState = $cursor->saveState();

        $emojiCode = $cursor->match('/(?<=:)[a-z0-9\+\-_]+(?=:)/');
        if (empty($emojiCode)) {
            $cursor->restoreState($previousState);

            return false;
        }

        $cursor->advance();

        $inlineContext->getContainer()->appendChild(new EmojiElement(
            Cache::tags('emoji')->get($emojiCode, $emojiCode)
        ));

        return true;
    }
}
