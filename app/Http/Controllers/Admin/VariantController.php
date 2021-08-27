<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Images\Image;
use Carbon\Carbon;
use App\Models\Products\Product;
use App\Models\Variants\Requests\CreateVariantRequest;
use App\Models\Variants\Requests\UpdateVariantRequest;
use App\Models\Variants\Variant;
use InterventionImage;

class VariantController extends Controller
{

    public function create($productId)
    {
        $product = Product::find($productId);
        return view('admin.product.variant.create', compact('product'));
    }

    public function store(CreateVariantRequest $request, $productId)
    {
        $data = $request->all();
        $data['product_id'] = $productId;
        $data['featured_image'] = $this->_uploadThumbnail($request->featured_image);
        Variant::create($data);
        return redirect()->route('admin.products.edit', $productId)->with('message', 'Thêm mới mẫu mã sản phẩm thành công!');
    }

    public function edit($productId, $variantId)
    {
        $variant = Variant::where(['product_id' => $productId, 'id' => $variantId])->firstOrFail();
        $product = $variant->product;
        return view('admin.product.variant.edit', compact('variant', 'product'));
    }

    public function update(UpdateVariantRequest $request, $productId, $variantId)
    {
        $data = $request->all();
        if (Variant::where([
            ['size', $request->size],
            ['color', $request->color],
            ['id', '!=', $variantId]
        ])->count()) {
            return redirect()->route('admin.variants.edit', ['product_id' => $productId, 'id' => $variantId])->with('error', 'Mẫu mã này đã được có, vui lòng kiểm tra lại');
        }

        $variant = Variant::where(['id' => $variantId, 'product_id' => $productId])->first();
        if (!empty($variant)) {
            if ($request->has('featured_image')) {
                $data['featured_image'] = $this->_uploadThumbnail($request->featured_image);
            }
            $variant->update($data);
            return redirect()->route('admin.products.edit', $productId)->with('message', 'Cập nhập mẫu mã sản phẩm thành công!');
        }
        return redirect()->route('admin.variants.edit', ['product_id' => $productId, 'id' => $variantId])->with('error', 'Có lỗi trong quá trình update');
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

        $destinationPath  = storage_path('app/public') . '/images/';
        $img = InterventionImage::make($file->path());
        $img->fit(50, 50, function ($constraint) { 
            $constraint->upsize();
        })->save($destinationPath . $fileName . '-50x50' . '.' . $fileExt, 80);

        $img->fit(100, 100, function ($constraint) { 
            $constraint->upsize();
        })->save($destinationPath . $fileName . '-100x100' . '.' . $fileExt, 80);
        // $file->storeAs('public/images', $fileName . '-300x200' . '.' . $fileExt);
        return $image->id;
    }
}