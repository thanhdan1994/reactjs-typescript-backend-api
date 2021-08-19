<?php

namespace App\Models\Categories\Repositories\Interfaces;

use App\Models\BaseRepositoryInterface;
use App\Models\Categories\Category;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function createCategory(array $data) : Category;

    public function listCategories(array $condition = array(), string $order = 'id', string $sort = 'desc', $except = [], string $withCount = 'products') : Collection;

    public function findCategoryBySlug(array $slug) : Category;

    public function findCategoryById(int $id) : Category;

    public function updateCategory(array $data) : bool;

    public function deleteCategory(int $id) : bool;
}
