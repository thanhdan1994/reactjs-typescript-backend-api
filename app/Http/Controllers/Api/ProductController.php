<?php
namespace App\Http\Controllers\Api;

use App\Models\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Products\Transformations\ProductTransformable;

class ProductController extends Controller
{
    use ProductTransformable;

    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepo = $productRepository;
    }


    public function index(Request $request)
    {
        $limit = $request->limit ?: 10;
        $page = $request->page ?: 1;
        $condition = ['status' => 1];
        if ($request->has('category')) {
            $condition['category_id'] =  $request->category;
        }
        if ($request->has('brand')) {
            $condition['brand_id'] =  $request->brand;
        }
        if ($request->has('price')) {
            $conditionPrice = $this->_getConditionFilterByPrice($request->price);
            if (!empty($conditionPrice)) {
                $condition[] = $conditionPrice;
            }

        }
        $products = $this->productRepo->listProducts($condition, $page, $limit);
        $products = $products->map(function (Product $product) {
            return $this->transformProduct($product);
        });
        return response()->json($products, 200);
    }

    public function show($id)
    {
        $product = $this->productRepo->findProductById($id, true);
        return $product;
    }

    private function _getConditionFilterByPrice($priceText)
    {
        $filter = [];
        switch ($priceText) {
            case 'duoi-hai-trieu':
                $filter = ['amount', '<', '2000000'];
                break;
            case 'tu-hai-den-nam-trieu':
                $filter = [
                    'and' => [
                        ['amount', '>=', '2000000'],
                        ['amount', '<=', '5000000'],
                    ]
                ];
                break;
            case 'tu-nam-den-muoi-trieu':
                $filter = [
                    'and' => [
                        ['amount', '>=', '5000000'],
                        ['amount', '<=', '10000000'],
                    ]
                ];
                break;
            case 'tu-muoi-den-hai-muoi-trieu':
                $filter = [
                    'and' => [
                        ['amount', '>=', '10000000'],
                        ['amount', '<=', '20000000'],
                    ]
                ];
                break;
            case 'tren-hai-muoi-trieu':
                $filter = ['amount', '>', '20000000'];
                break;
            default:
                break;
        }
        return $filter;
    }
}
