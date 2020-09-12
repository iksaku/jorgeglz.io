<?php

namespace App\Observers;

use App\Models\Post;
use Cache;

class PostCacheObserver
{
    protected function updatePostCache(Post $post): void
    {
        if ($post->published && !$post->trashed()) {
            markdown($post);
            markdown($post, true);
        }
    }

    protected function deletePostCache(Post $post): void
    {
        Cache::tags('markdown')->forget($post->getCacheKey());
        Cache::tags(['markdown', 'inline'])->forget($post->getCacheKey());
    }

    /**
     * Cache new Post.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function created(Post $post)
    {
        $this->updatePostCache($post);
    }

    /**
     * Re-cache updated post content.
     *
     * @param Post $post
     * @return void
     */
    public function updated(Post $post)
    {
        $this->deletePostCache($post);
        $this->updatePostCache($post);
    }

    /**
     * Removes cached post content.
     *
     * @param Post $post
     * @return void
     */
    public function deleted(Post $post)
    {
        $this->deletePostCache($post);
    }

    /**
     * Cache restored post.
     *
     * @param Post $post
     * @return void
     */
    public function restored(Post $post)
    {
        $this->updatePostCache($post);
    }

    /**
     * Ensures that cached post content is removed.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        $this->deletePostCache($post);
    }
}
