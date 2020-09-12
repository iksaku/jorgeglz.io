<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user is admin and has full access.
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user): bool
    {
        return $user->email === 'iksaku@me.com' ?: null;
    }

    /**
     * Determine whether the user can view any posts.
     *
     * @param User|null $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param User|null $user
     * @param Post $post
     * @return bool
     */
    public function view(?User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @return mixed
     */
    public function create()
    {
        return false;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param User $user
     * @param Post $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return $post->author->is($user);
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param User $user
     * @param Post $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return $post->author->is($user);
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param User $user
     * @param Post $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        return $post->author->is($user);
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param User $user
     * @param Post $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        return $post->author->is($user);
    }
}
