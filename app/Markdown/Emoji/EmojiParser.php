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

        $shortCode = $cursor->match('/(?<=:)[a-z0-9\+\-_]+(?=:)/');
        if (empty($shortCode) || empty($emoji = emoji($shortCode))) {
            $cursor->restoreState($previousState);

            return false;
        }

        $cursor->advance(); // Removes trailing ':'

        $inlineContext->getContainer()->appendChild(new EmojiElement($emoji, $shortCode));

        return true;
    }
}
