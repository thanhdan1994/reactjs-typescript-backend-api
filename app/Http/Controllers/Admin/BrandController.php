<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brands\Repositories\BrandRepository;
use App\Models\Brands\Repositories\Interfaces\BrandRepositoryInterface;
use App\Models\Brands\Requests\CreateBrandRequest;
use App\Models\Brands\Requests\UpdateBrandRequest;
use App\Models\Images\Image;
use Carbon\Carbon;

class BrandController extends Controller
{
    protected $brandRepo;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepo = $brandRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', BrandRepository::class);
        $categories = $this->brandRepo->listBrands();
        return view('admin.brand.index', [
            'brands' => $this->brandRepo->paginateArrayResults(
                $categories->all(),
                config('constants.admin.paginate')
            )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', BrandRepository::class);
        $brands = $this->brandRepo->listBrands();
        return view('admin.brand.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBrandRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBrandRequest $request)
    {
        $this->authorize('create', BrandRepository::class);
        $data = $request->all();
        if ($request->file('logo')) {
            $file = $request->logo;
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '-thumbnail-' . Carbon::now()->timestamp;
            $fileExt = $file->extension();
            $file->storeAs('public/images', $fileName . '.' . $fileExt);
            $image = Image::create([
                'name' => $fileName,
                'ext' => $fileExt,
                'store_path' => 'storage/images'
            ]);
            $data['logo'] = $image->id;
            $this->brandRepo->createBrand($data);
        }
        return redirect()->route('admin.brands.index')->with('message', 'Thêm thương hiệu mới thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = $this->brandRepo->findBrandById($id);
        $this->authorize('update', $brand);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBrandRequest $request
     * @param int $id
     * @return Response
     * @throws \App\Models\Categories\Exceptions\BrandUpdateException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        $brand = $this->brandRepo->findBrandById($id);
        $this->authorize('update', $brand);
        $data = $request->all();
        if ($request->file('logo')) {
            $file = $request->logo;
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '-thumbnail-' . Carbon::now()->timestamp;
            $fileExt = $file->extension();
            $file->storeAs('public/images', $fileName . '.' . $fileExt);
            $image = Image::create([
                'name' => $fileName,
                'ext' => $fileExt,
                'store_path' => 'storage/images'
            ]);
            $data['logo'] = $image->id;
            $brand->update($data);
        }
        return redirect()->route('admin.brands.index')->with('message', 'Cập nhật thương hiệu thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
