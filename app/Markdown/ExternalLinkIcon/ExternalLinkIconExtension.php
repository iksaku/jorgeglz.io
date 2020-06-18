<?php

namespace App\Markdown\ExternalLinkIcon;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Inline\Element\Link;

class ExternalLinkIconExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
            ->addInlineRenderer(Link::class, new ExternalLinkInterceptor(), 10)
            ->addInlineRenderer(ExternalLinkIconElement::class, new ExternalLinkIconRenderer());
    }
}
