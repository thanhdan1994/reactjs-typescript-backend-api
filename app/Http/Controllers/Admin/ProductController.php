<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use App\Models\Products\Repositories\ProductRepository;
use App\Models\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Brands\Repositories\Interfaces\BrandRepositoryInterface;
use App\Models\Images\Image;
use App\Models\Images\ProductImage;
use App\Models\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Products\Requests\CreateProductRequest;
use App\Models\Products\Requests\UpdateProductRequest;
use App\Models\Products\Transformations\ProductTransformable;
use App\Models\Tools\UploadableTrait;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

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
        $products = $this->productRepo->getAllProducts();
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
        $data['featured_image'] = $this->_uploadThumbnail($request->featured_image);
        $product = $this->productRepo->createProduct($data);

        // create product image
        if ($request->has('ProductImages')) {
            $this->__insertProductImages($request->ProductImages, $product->id);
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
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->_uploadThumbnail($request->featured_image);
        }
        $product->update($data);

        // upsert/create product image
        if ($request->has('ProductImages')) {
            $this->__insertProductImages($request->ProductImages, $product->id);
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

    private function __insertProductImages(array $imagesId, $productId)
    {
        ProductImage::where(['product_id' => $productId])->delete();
        collect($imagesId)->each(function ($imageId, $key) use ($productId) {
            ProductImage::updateOrCreate(
                ['product_id' => $productId, 'image_id' => $imageId],
                ['sort' => $key + 1]
            );
        });
        return true;
    }

    private function _uploadThumbnail($file)
    {
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '-thumbnail-' . Carbon::now()->timestamp;
        $fileExt = $file->extension();
        $file->storeAs('public/images', $fileName . '.' . $fileExt);
        $image = Image::create([
            'name' => $fileName,
            'ext' => $fileExt,
            'store_path' => 'storage/images'
        ]);
        return $image->id;
    }
}
