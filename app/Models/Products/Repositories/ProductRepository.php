<?php
namespace App\Models\Products\Repositories;

use App\Models\BaseRepository;
use App\Models\Products\Exceptions\ProductCreateErrorException;
use App\Models\Products\Exceptions\ProductNotFoundException;
use App\Models\Products\Exceptions\ProductUpdateErrorException;
use App\Models\Products\Product;
use App\Models\Products\Transformations\ProductTransformable;
use App\Models\Tools\UploadableTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Models\Products\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Collection;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    use UploadableTrait, ProductTransformable;
    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        parent::__construct($product);
        $this->model = $product;
    }

    public function createProduct(array $data): Product
    {
        // TODO: Implement createProduct() method.
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new ProductCreateErrorException($e);
        }
    }

    public function findProductById(int $id, $transform = true): Product
    {
        // TODO: Implement findProductBySlug() method.
        try {
            if ($transform) {
                return $this->transformProductDetail($this->findOneOrFail($id));
            }
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ProductNotFoundException($e);
        }
    }

    public function saveProductImages(Collection $collection) : array
    {
        $images = [];
        foreach ($collection as $key => $file) {
            $filename = $this->storeFile($file);
            $images[] = $filename;
        }
        return $images;
    }

    public function listProducts(array $condition = [], int $page = 1, int $limit = 10, string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        $skip = $page * $limit - $limit;
        return $this->model->where($condition)->select($columns)->orderBy($order, $sort)->skip($skip)->take($limit)->get();
    }

    public function updateProduct(array $data) : bool
    {
        try {
            return $this->model->where('id', $this->model->id)->update($data);
        } catch (QueryException $e) {
            throw new ProductUpdateErrorException($e);
        }
    }

    public function searchProduct(string $text): Collection
    {
        if (!empty($text)) {
            return $this->model->searchProduct($text);
        } else {
            return $this->listProducts();
        }
    }

    public function listProductsPaginate(int $limit = 10, string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->paginate($limit, $orderBy, $sortBy);
    }

    public function searchProductPaginate($text, int $limit = 10, string $orderBy = 'id', string $sortBy = 'asc')
    {
        if (!empty($text)) {
            return $this->model->searchProductPaginate($text, $limit);
        } else {
            return $this->listProductsPaginate($limit, 'id',  'desc');
        }
    }
}
