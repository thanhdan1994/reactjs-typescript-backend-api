<?php
namespace App\Models\Products\Repositories\Interfaces;

use App\Models\BaseRepositoryInterface;
use App\Models\Products\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function createProduct(array $data) : Product;

    public function findProductById(int $id, $transform = true) : Product;

    public function saveProductImages(Collection $collection) : array;

    public function listProducts(array $condition = [], int $page = 1, int $limit = 10, string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;

    public function updateProduct(array $data) : bool;

    public function searchProduct(string $text) : Collection;

    public function searchProductPaginate($text, int $limit = 10);

    public function listProductsPaginate(int $limit = 10);
}
