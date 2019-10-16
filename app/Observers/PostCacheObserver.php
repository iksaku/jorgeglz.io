<?php

namespace App\Observers;

use App\Post;
use Cache;

class PostCacheObserver
{
    /**
     * Handle the post "created" event.
     *
     * @param Post $post
     * @return void
     */
    public function created(Post $post)
    {
        // Cache the new Post
        markdown($post);
        markdown($post, true);
    }

    /**
     * Handle the post "updated" event.
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
     * Handle the post "deleted" event.
     *
     * @param Post $post
     * @return void
     */
    public function deleted(Post $post)
    {
        Cache::tags('markdown')->forget($key = 'post:'.$post->slug);
        Cache::tags('markdown')->forget($key.':inline');
    }

    /**
     * Handle the post "restored" event.
     *
     * @param Post $post
     * @return void
     */
    public function restored(Post $post)
    {
        $this->created($post);
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param Post $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        $this->deleted($post);
    }
}
