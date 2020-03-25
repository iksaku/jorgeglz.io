<?php

namespace App\Observers;

use App\Post;
use Cache;

class PostCacheObserver
{
    /**
     * Cache new Post.
     *
     * @param Post $post
     * @return void
     */
    public function created(Post $post)
    {
        markdown($post);
        markdown($post, true);
    }

    /**
     * Re-cache updated post content.
     *
     * @param Post $post
     * @return void
     */
    public function updated(Post $post)
    {
        $this->deleted($post);

        if (!$post->trashed()) {
            $this->created($post);
        }
    }

    /**
     * Removes cached post content.
     *
     * @param Post $post
     * @return void
     */
    public function deleted(Post $post)
    {
        Cache::tags('markdown')->forget(markdown_cache_key($post));
        Cache::tags(['markdown', 'inline'])->forget(markdown_cache_key($post));
    }

    /**
     * Cache post again.
     *
     * @param Post $post
     * @return void
     */
    public function restored(Post $post)
    {
        $this->created($post);
    }

    /**
     * Ensures that cached post content is removed.
     *
     * @param Post $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        $this->deleted($post);
    }
}
