<?php

namespace App\Policies;

use App\Models\Brands\Brand;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any brands.
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
     * Determine whether the user can view the brand.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Brands\Brand  $brand
     * @return mixed
     */
    public function view(User $user, Brand $brand)
    {
        if ($user->can('view')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create brands.
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
     * Determine whether the user can update the brand.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Brands\Brand  $brand
     * @return mixed
     */
    public function update(User $user, Brand $category)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the brand.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Brands\Brand  $brand
     * @return mixed
     */
    public function delete(User $user, Brand $brand)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }
    /**
     * Determine whether the user can restore the brand.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Brands\Brand  $brand
     * @return mixed
     */
    public function restore(User $user, Brand $brand)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the brand.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Brands\Brand  $brand
     * @return mixed
     */
    public function forceDelete(User $user, Brand $brand)
    {
        //
    }
}
