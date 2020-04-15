<?php

namespace App\Markdown\Emoji;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;

class EmojiExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
            ->addInlineParser(new EmojiParser())
            ->addInlineRenderer(EmojiElement::class, new EmojiRenderer());
    }
}
