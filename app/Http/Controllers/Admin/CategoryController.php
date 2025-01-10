<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Enum\CategoryStatus;
use App\Enum\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
    ) {
        $this->middleware('permission:' . Acl::PERMISSION_CATEGORY_LIST)->only('index');
        $this->middleware('permission:' . Acl::PERMISSION_CATEGORY_ADD)->only(['create', 'store']);
        $this->middleware('permission:' . Acl::PERMISSION_CATEGORY_EDIT)->only(['edit', 'update']);
        $this->middleware('permission:' . Acl::PERMISSION_CATEGORY_DELETE)->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = $this->categoryRepository->serverPaginationFilteringForAdmin($request->all());
            return CategoryResource::collection($categories);
        }

        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = CategoryStatus::options(true);

        return view('admin.category.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->categoryRepository->create($request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Thêm mới danh mục thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Thêm mới danh mục thất bại.'));

        return to_route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $statuses = CategoryStatus::options(true);

        return view('admin.category.edit', compact('category', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->categoryRepository->update($category, $request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chỉnh sửa danh mục thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Chỉnh sửa danh mục thất bại.'));

        return to_route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($this->categoryRepository->destroy($category)) {
            return response()->json([
                'message' => __('Xóa danh mục thành công.'),
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => __('Xóa danh mục thất bại.'),
        ], Response::HTTP_BAD_REQUEST);
    }
}
