<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

/**
 * @tags Danh mục dự án (Category)
 */
class CategoryController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
    ) {
        //
    }

    /**
     * Danh sách danh mục dự án.
     *
     * Lấy danh sách danh mục dự án.
     *
     * @response array{
     *   data: CategoryResource,
     *   message: string,
     * }
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->okResponse(
            CategoryResource::collection($this->categoryRepository->all()),
            __('Danh sách danh mục dự án'),
        );
    }
}