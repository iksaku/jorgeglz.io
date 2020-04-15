<?php

namespace App\Markdown;

use App\Markdown\Emoji\EmojiExtension;
use App\Markdown\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Environment;
use League\CommonMark\Extension\InlinesOnly\InlinesOnlyExtension;

class MarkdownConverter
{
    public static function makeConverter(): CommonMarkConverter
    {
        return self::createConverter(Environment::createGFMEnvironment());
    }

    public static function makeInlineConverter(): CommonMarkConverter
    {
        $environment = new Environment();
        $environment->addExtension(new InlinesOnlyExtension());

        return self::createConverter($environment);
    }

    private static function createConverter(ConfigurableEnvironmentInterface $environment): CommonMarkConverter
    {
        $environment
            ->addExtension(new EmojiExtension())
            ->addExtension(new HeadingPermalinkExtension());

        return new CommonMarkConverter(config('markdown'), $environment);
    }
}
