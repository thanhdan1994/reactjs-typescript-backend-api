<?php

namespace App\Models\Brands\Repositories;

use App\Models\BaseRepository;
use App\Models\Brands\Exceptions\BrandCreateException;
use App\Models\Brands\Exceptions\BrandUpdateException;
use App\Models\Brands\Exceptions\BrandNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Brands\Repositories\Interfaces\BrandRepositoryInterface;
use App\Models\Brands\Brand;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    /**
     * BrandRepository constructor.
     * @param Brand $brand
     */
    public function __construct(Brand $brand)
    {
        parent::__construct($brand);
        $this->model = $brand;
    }

    public function createBrand(array $data): Brand
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new BrandCreateException($e);
        }
    }

    /**
     * List all the brands
     *
     * @param array $condition
     * @param string $order
     * @param string $sort
     * @param array $except
     * @param string $withCount
     * @return Collection
     */
    public function listBrands(array $condition = array(), string $order = 'id', string $sort = 'desc', $except = [], string $withCount = 'products') : Collection
    {
        return $this->model->withCount($withCount)->where($condition)->orderBy($order, $sort)->get()->except($except);
    }

    public function updateBrand(array $data): bool
    {
        try {
            return $this->model->where('id', $this->model->id)->update($data);
        } catch (QueryException $e) {
            throw new BrandUpdateException($e);
        }
    }

    public function deleteBrand(int $id): bool
    {
        try {
            return $this->model->where('id', $id)->delete();
        } catch (QueryException $e) {
            throw new BrandUpdateException($e);
        }
    }

    public function findBrandById(int $id): Brand
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new BrandNotFoundException($e);
        }
    }
}
