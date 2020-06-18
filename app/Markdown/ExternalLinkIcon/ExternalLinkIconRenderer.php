<?php

namespace App\Markdown\ExternalLinkIcon;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class ExternalLinkIconRenderer implements InlineRendererInterface
{
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof ExternalLinkIconElement)) {
            throw new \InvalidArgumentException('Incompatible inline type: '.get_class($inline));
        }

        return new HtmlElement('span', [
            'class' => 'fas fa-external-link-alt fa-sm ml-1',
        ]);
    }
}
