<?php

namespace App\Markdown\Emoji;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class EmojiRenderer implements InlineRendererInterface
{
    /**
     * {@inheritdoc}
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof EmojiElement)) {
            throw new \InvalidArgumentException('Incompatible inline type '.get_class($inline));
        }

        return new HtmlElement('span', [
            'class' => 'font-emoji',
            'alt' => $inline->getAlt(),
        ], $htmlRenderer->renderInlines($inline->children()), false);
    }
}
