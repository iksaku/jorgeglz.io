<?php

namespace App\Http\Livewire;

use App\Post;
use Livewire\Component;

class PostPreviewContent extends Component
{
    /** @var string */
    public $content;

    public function mount(Post $post, ?string $content = null)
    {
        $this->content = $content ?? $post->content;

        if (!isset($content) && isset($post->content)) {
            $this->computedPropertyCache['renderedContent'] = markdown($post);
        }
    }

    public function getRenderedContentProperty(): string
    {
        if (empty($this->content)) {
            return '';
        }

        return app('github')->markdown()->render($this->content, 'markdown');
    }

    public function render()
    {
        return view('livewire.post-preview-content');
    }
}
