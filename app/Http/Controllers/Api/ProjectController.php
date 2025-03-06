<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\ProjectRequest;
use App\Http\Resources\Api\ProjectResource;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

/**
 * @tags Dự án (Project)
 */
class ProjectController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected ProjectRepositoryInterface $projectRepository,
    ) {
        //
    }

    /**
     * Lấy danh sách dự án.
     *
     * Lấy danh sách dự án theo các trường tìm kiếm.
     * - status: Trạng thái dự án (int) (Xử lý ở frontend)
     * 1. Đang thực hiện
     * 2. Đạt mục tiêu
     * 3. Đã kết thúc
     * 4. Tạm dừng
     *
     * @response ProjectResource
     *
     * @param ProjectRequest $request
     *
     * @return JsonResponse
     */
    public function index(ProjectRequest $request)
    {
        return $this->okResponse(
            ProjectResource::collection($this->projectRepository->serverPaginationFilteringForApi($request->all())),
            __('Danh sách dự án'),
        );
    }
}
