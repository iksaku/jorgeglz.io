<?php

namespace App\Markdown;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Extension\InlinesOnly\InlinesOnlyExtension;

class InlineRenderExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addExtension(new InlinesOnlyExtension());
    }
}
