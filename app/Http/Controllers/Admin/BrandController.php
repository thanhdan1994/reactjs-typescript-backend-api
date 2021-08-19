<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brands\Brand;
use Illuminate\Http\Request;
use App\Models\Brands\Repositories\BrandRepository;
use App\Models\Brands\Repositories\Interfaces\BrandRepositoryInterface;
use Illuminate\Support\Str;
use App\Models\Brands\Requests\UpdateBrandRequest;

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
        $this->authorize('viewAny', Brand::class);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return Response
     * @throws \App\Models\Categories\Exceptions\BrandUpdateException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        $brand = $this->brandRepo->findBrandById($id);
        $this->authorize('update', $brand);
        $brandRepo = new BrandRepository($brand);
        $data = $request->except('_token', '_method', 'featured_image');
        if ($request->file('featured_image')) {
            $media = $brand
                ->addMedia($request->featured_image)
                ->toMediaCollection('images');
            $data['logo'] = $media->id;
        }
        $brandRepo->updateBrand($data);
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
