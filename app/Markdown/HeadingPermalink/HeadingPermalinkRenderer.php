<?php

namespace App\Markdown\HeadingPermalink;

use Illuminate\Support\Str;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Heading;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\Link;

class HeadingPermalinkRenderer implements BlockRendererInterface
{
    /**
     * {@inheritdoc}
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof Heading)) {
            throw new \InvalidArgumentException('Incompatible block type: '.get_class($block));
        }

        $tag = 'h'.$block->getLevel();

        $slug = Str::of($block->getStringContent())->slug();

        $block->data['attributes']['id'] = $slug;
        $attrs = $block->getData('attributes', []);

        $link = new Link(url()->current().'#'.$slug, '#', 'Permalink');
        $link->data['attributes']['class'] = 'permalink';

        $block->appendChild($link);

        return new HtmlElement($tag, $attrs, $htmlRenderer->renderInlines($block->children()));
    }
}
