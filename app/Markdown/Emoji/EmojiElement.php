<?php

namespace App\Markdown\Emoji;

use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Text;

class EmojiElement extends AbstractInline
{
    protected string $emoji;

    protected ?string $alt;

    public function __construct(string $emoji, ?string $alt = null)
    {
        $this->emoji = $emoji;
        $this->alt = $alt;
        $this->appendChild(new Text($emoji));
    }

    public function isContainer(): bool
    {
        return true;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }
}
