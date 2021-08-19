<?php

namespace App\Models\Categories\Repositories;

use App\Models\BaseRepository;
use App\Models\Categories\Exceptions\CategoryCreateException;
use App\Models\Categories\Exceptions\CategoryNotFoundException;
use App\Models\Categories\Exceptions\CategoryUpdateException;
use App\Models\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Categories\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
        $this->model = $category;
    }

    public function createCategory(array $data): Category
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CategoryCreateException($e);
        }
    }

    /**
     * List all the categories
     *
     * @param array $condition
     * @param string $order
     * @param string $sort
     * @param array $except
     * @param string $withCount
     * @return Collection
     */
    public function listCategories(array $condition = array(), string $order = 'id', string $sort = 'desc', $except = [], string $withCount = 'products') : Collection
    {
        return $this->model->withCount($withCount)->where($condition)->orderBy($order, $sort)->get()->except($except);
    }

    public function findCategoryBySlug(array $slug): Category
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e);
        }
    }


    public function findCategoryById(int $id): Category
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e);
        }
    }

    public function updateCategory(array $data): bool
    {
        try {
            return $this->model->where('id', $this->model->id)->update($data);
        } catch (QueryException $e) {
            throw new CategoryUpdateException($e);
        }
    }

    public function deleteCategory(int $id): bool
    {
        // TODO: Implement deleteCategory() method.
        try {
            return $this->model->where('id', $id)->delete();
        } catch (QueryException $e) {
            throw new CategoryUpdateException($e);
        }
    }
}
