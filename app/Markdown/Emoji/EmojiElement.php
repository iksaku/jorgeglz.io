<?php

namespace App\Markdown\Emoji;

use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Text;

class EmojiElement extends AbstractInline
{
    protected string $emoji;

    public function __construct(string $emoji)
    {
        $this->appendChild(new Text($emoji));
    }

    public function isContainer(): bool
    {
        return true;
    }
}
