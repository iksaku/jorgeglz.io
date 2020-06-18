<?php

namespace App\Markdown\ExternalLinkIcon;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class ExternalLinkInterceptor implements InlineRendererInterface
{
    /**
     * {@inheritdoc}
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Link)) {
            throw new \InvalidArgumentException('Incompatible inline type: '.get_class($inline));
        }

        if ($inline->getData('external')) {
            $inline->appendChild(new ExternalLinkIconElement());
        }

        // Little hack to intercept rendering right before running base LinkRenderer
    }
}
