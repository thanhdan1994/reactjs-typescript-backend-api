<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories\Category;
use App\Models\Categories\Repositories\CategoryRepository;
use App\Models\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Categories\Requests\CreateCategoryRequest;
use App\Models\Categories\Requests\UpdateCategoryRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Models\Categories\Transformations\CategoryTransformable;

class CategoryController extends Controller
{
    use CategoryTransformable;

    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Category::class);
        $categories = $this->categoryRepo->listCategories();
        $categories = $categories->map(function (Category $category) {
            return $this->transformCategory($category);
        });
        return view('admin.category.index', [
            'categories' => $this->categoryRepo->paginateArrayResults(
                $categories->all(),
                Config::get('constants.admin.paginate')
            )
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
        $this->authorize('create', Category::class);
        $categories = $this->categoryRepo->listCategories()->where('parent_id', 0);
        return view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCategoryRequest $request
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->authorize('create', Category::class);
        $data = $request->except('_token', 'featured_image');
        $category = $this->categoryRepo->createCategory($data);
        if ($request->file('featured_image')) {
            $media = $category
                ->addMedia($request->featured_image)
                ->toMediaCollection('images');
            $categoryRepo = new CategoryRepository($category);
            $categoryRepo->updateCategory(['featured_image' => $media->id]);
        }
        return redirect()->route('admin.categories.index')->with('message', 'Tạo chuyên mục mới thành công!');
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
        $category = $this->categoryRepo->findCategoryById($id);
        $this->authorize('update', $category);
        $categories = $this->categoryRepo->listCategories()->where('parent', 0);
        return view('admin.category.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return Response
     * @throws \App\Models\Categories\Exceptions\CategoryUpdateException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryRepo->findCategoryById($id);
        $this->authorize('update', $category);
        $categoryRepo = new CategoryRepository($category);
        $data = $request->except('_token', '_method', 'featured_image');
        $data['slug'] = Str::slug($request->input('category'));
        if ($request->file('featured_image')) {
            $media = $category
                ->addMedia($request->featured_image)
                ->toMediaCollection('images');
            $data['featured_image'] = $media->id;
        }
        $categoryRepo->updateCategory($data);
        return redirect()->route('admin.categories.index')->with('message', 'Cập nhật chuyên mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $category = $this->categoryRepo->findCategoryById($id);
        $this->authorize('delete', $category);
        $this->categoryRepo->deleteCategory($id);
        return redirect()->route('admin.categories.index')->with('message', 'Xóa chuyên mục thành công!');
    }
}
