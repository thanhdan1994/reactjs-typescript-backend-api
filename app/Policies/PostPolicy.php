<?php

namespace App\Policies;

use App\Models\Posts\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any posts.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
       if ($user->can('viewAny permission')) {
           return true;
       }
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param User $user
     * @param Post $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
        if ($user->can('view permission')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('create permission')) {
            return true;
        }
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
        if ($user->can('edit permission')) {
            return true;
        }

        if ($user->can('edit own permission')) {
            return $user->id === $post->user_id;
        }
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
        if ($user->can('delete permission')) {
            return true;
        }

        if ($user->can('delete own permission')) {
            return $user->id === $post->user_id;
        }
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
        //
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
        //
    }
}
