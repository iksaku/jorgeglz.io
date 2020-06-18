<?php

namespace App\Markdown\ExternalLinkIcon;

use League\CommonMark\Inline\Element\AbstractInline;

class ExternalLinkIconElement extends AbstractInline
{
    public function isContainer(): bool
    {
        return true;
    }
}
