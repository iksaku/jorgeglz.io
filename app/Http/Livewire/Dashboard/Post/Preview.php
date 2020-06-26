<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Http\Livewire\Dashboard\Post;

use App\Markdown\CacheableInterface;
use App\Post;
use Livewire\Component;

class Preview extends Component implements CacheableInterface
{
    /** @var string */
    public $content;

    public function mount(Post $post, ?string $content = null)
    {
        $this->content = $content ?? $post->content;
    }

    public function getRenderedContentProperty(): string
    {
        if (empty($this->content)) {
            return '<em class="text-gray-500">No content.</em>';
        }

        return markdown($this, false, false);
    }

    public function render()
    {
        return view('livewire.dashboard.post.preview');
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
