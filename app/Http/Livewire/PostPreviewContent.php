<?php

namespace App\Http\Livewire;

use App\Markdown\CacheableInterface;
use App\Post;
use Livewire\Component;

class PostPreviewContent extends Component implements CacheableInterface
{
    /** @var string */
    public $content;

    public function mount(Post $post, ?string $content = null)
    {
        $this->content = $content ?? $post->content;

        if (!isset($content) && isset($post->content)) {
            $this->computedPropertyCache['renderedContent'] = markdown($post, false, false);
        }
    }

    public function getRenderedContentProperty(): string
    {
        if (empty($this->content)) {
            return '';
        }

        return markdown($this, false, false);
    }

    public function render()
    {
        return view('livewire.post-preview-content');
    }

    public function getCacheKey(): string
    {
        return 'post-preview';
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
