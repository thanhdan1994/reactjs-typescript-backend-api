<?php
namespace App\Policies;

use App\Models\Products\Product;
use App\User;

class ProductPolicy
{
    public function viewAny(User $user)
    {
        if ($user->can('viewAny permission')) {
            return true;
        }
    }
    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('create permission')) {
            return true;
        }
    }

    public function update(User $user, Product $product)
    {
        if ($user->can('edit permission')) {
            return true;
        }
    }

    public function delete(User $user, Product $product)
    {
        if ($user->can('delete permission')) {
            return true;
        }
    }
}
