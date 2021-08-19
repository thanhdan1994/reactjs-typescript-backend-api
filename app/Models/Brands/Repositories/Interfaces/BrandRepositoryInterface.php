<?php

namespace App\Models\Brands\Repositories\Interfaces;

use App\Models\BaseRepositoryInterface;
use App\Models\Brands\Brand;
use Illuminate\Support\Collection;

interface BrandRepositoryInterface extends BaseRepositoryInterface
{
    public function createBrand(array $data) : Brand;

    public function listBrands(array $condition = array(), string $order = 'id', string $sort = 'desc', $except = [], string $withCount = 'posts') : Collection;

    public function updateBrand(array $data) : bool;

    public function deleteBrand(int $id) : bool;

    public function findBrandById(int $id) : Brand;
}
