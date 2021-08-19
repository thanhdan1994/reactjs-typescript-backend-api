<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use App\Models\Products\MediaProduct;
use App\Models\Products\Repositories\ProductRepository;
use App\Models\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Brands\Repositories\Interfaces\BrandRepositoryInterface;
use App\Models\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Products\Requests\CreateProductRequest;
use App\Models\Products\Requests\UpdateProductRequest;
use App\Models\Products\Transformations\ProductTransformable;
use App\Models\Tools\UploadableTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use ProductTransformable, UploadableTrait;

    protected $productRepo;

    protected $categoryRepo;

    protected $brandRepo;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        BrandRepositoryInterface $brandRepository
    ) {
        $this->productRepo = $productRepository;
        $this->categoryRepo = $categoryRepository;
        $this->brandRepo = $brandRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Product::class);
        $products = $this->productRepo->listProducts();
        if (request()->has('q') && request()->input('q') != '') {
            $products = $this->productRepo->searchProduct(request()->input('q'));
        }

        return view('admin.product.index', [
            'products' => $this->productRepo->paginateArrayResults($products->all(), Config::get('constants.admin.paginate'))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Product::class);
        $categories = $this->categoryRepo->listCategories();
        $brands = $this->brandRepo->listBrands();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateProductRequest $request
     * @return Response
     * @throws \App\Models\Products\Exceptions\ProductUpdateErrorException
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateProductRequest $request)
    {
        $this->authorize('create', ProductRepository::class);
        $data = $request->all();
        $data['status'] = $request->has('status');
        $product = $this->productRepo->createProduct($data);
        if ($request->file('featured_image')) {
            $media = $product
                ->addMedia($request->featured_image)
                ->toMediaCollection('images');
            $productRepo = new ProductRepository($product);
            $productRepo->updateProduct(['featured_image' => $media->id]);
        }

        if ($request->get('images-base64')) {
            MediaProduct::where('product_id', $product->id)->delete();
            foreach ($request->get('images-base64') as $file) {
                $media = $product->addMediaFromBase64($file)->usingFileName(Str::random(20).'.jpg')->toMediaCollection('images');
                MediaProduct::create([
                    'media_id' => $media->id,
                    'product_id' => $product->id
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('message', 'Tạo bài viết mới thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $product = $this->productRepo->findProductById($id, false);
        $this->authorize('update', $product);
        $categories = $this->categoryRepo->listCategories();
        $brands = $this->brandRepo->listBrands();
        return view('admin.product.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param int $id
     * @return Response
     * @throws \App\Models\Products\Exceptions\ProductUpdateErrorException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productRepo->findProductById($id, false);
        $this->authorize('update', $product);
        $data = $request->all();
        $data['status'] = $request->has('status');
        $product->update($data);
        if ($request->file('featured_image')) {
            $media = $product
                ->addMedia($request->featured_image)
                ->toMediaCollection('images');
            $product->featured_image  = $media->id;
            $product->save();
        }

        if ($request->get('images-base64')) {
            MediaProduct::where('product_id', $product->id)->delete();
            foreach ($request->get('images-base64') as $file) {
                $media = $product->addMediaFromBase64($file)->usingFileName(Str::random(20).'.jpg')->toMediaCollection('images');
                MediaProduct::create([
                    'media_id' => $media->id,
                    'product_id' => $product->id
                ]);
            }
        }
        return redirect()->route('admin.products.index')->with('message', 'Cập nhập bài viết thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $product = $this->productRepo->findProductById($id, false);
        $this->authorize('delete', $product);
        $product->delete();
        return redirect()->route('admin.products.index')->with('message', 'Sản phẩm có mã '. $id . ' đã được xóa thành công');
    }
}
