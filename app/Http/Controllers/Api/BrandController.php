<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brands\Repositories\Interfaces\BrandRepositoryInterface;
use App\Models\Brands\Transformations\BrandTransformable;

class BrandController extends Controller
{
    use BrandTransformable;

    protected $brandRepo;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepo = $brandRepository;
    }

    public function index()
    {
        $brands = $this->brandRepo->listBrands();
        $brands = $brands->map(function ($brand) {
            return $this->transformBrand($brand);
        });
        return $brands;
    }
}