<?php

namespace App\Markdown\Emoji;

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
        if (empty($emojiCode) || empty($emoji = emoji($emojiCode))) {
            $cursor->restoreState($previousState);

            return false;
        }

        $cursor->advance();

        $inlineContext->getContainer()->appendChild(new EmojiElement($emoji));

        return true;
    }
}
