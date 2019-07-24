<?php

namespace Iksaku\NovaExtendedMarkdown;

use Laravel\Nova\Fields\Markdown;

class NovaExtendedMarkdown extends Markdown
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'extended-markdown';
}
