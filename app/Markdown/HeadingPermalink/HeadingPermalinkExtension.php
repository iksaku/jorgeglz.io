<?php

namespace App\Markdown\HeadingPermalink;

use League\CommonMark\Block\Element\Heading;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;

class HeadingPermalinkExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
            ->addBlockRenderer(Heading::class, new HeadingPermalinkRenderer(), 10);
    }
}
