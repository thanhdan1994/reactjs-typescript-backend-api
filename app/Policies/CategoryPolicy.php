<?php

namespace App\Policies;

use App\Models\Categories\Category;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->can('viewAny permission')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Categories\Category  $category
     * @return mixed
     */
    public function view(User $user, Category $category)
    {
        if ($user->can('view')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Categories\Category  $category
     * @return mixed
     */
    public function update(User $user, Category $category)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Categories\Category  $category
     * @return mixed
     */
    public function delete(User $user, Category $category)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }
    /**
     * Determine whether the user can restore the category.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Categories\Category  $category
     * @return mixed
     */
    public function restore(User $user, Category $category)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the category.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Categories\Category  $category
     * @return mixed
     */
    public function forceDelete(User $user, Category $category)
    {
        //
    }
}
