<?php

namespace App\Policies;

use App\Tag;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user is admin and has full access.
     *
     * @param User $user
     * @return null
     */
    public function before(User $user)
    {
        return $user->email === 'iksaku@me.com' ?: null;
    }

    /**
     * Determine whether the user can view any tags.
     *
     * @param User|null $user
     * @return bool
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the tag.
     *
     * @param User|null $user
     * @param Tag $tag
     * @return bool
     */
    public function view(?User $user, Tag $tag)
    {
        return true;
    }

    /**
     * Determine whether the user can create tags.
     *
     * @return mixed
     */
    public function create()
    {
        return true;
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @return mixed
     */
    public function update()
    {
        return true;
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @return mixed
     */
    public function delete()
    {
        return true;
    }

    /**
     * Determine whether the user can restore the tag.
     *
     * @return mixed
     */
    public function restore()
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the tag.
     *
     * @return mixed
     */
    public function forceDelete()
    {
        return true;
    }
}
