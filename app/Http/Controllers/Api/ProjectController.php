<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProjectResource;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * - type: Loại dự án (string)
     * 1. 'Quyên góp'
     * 2. 'Tình nguyện'
     * 3. 'Quyên góp và tình nguyện'
     * - status: Trạng thái dự án (int) (Xử lý ở frontend)
     * 1. Đang thực hiện
     * 2. Đạt mục tiêu
     * 3. Đã kết thúc
     * 4. Tạm dừng
     * - category_id: ID danh mục dự án (int)
     * - role: Vai trò của người dùng (string)
     * 1. 'tổ chức gây quỹ'
     * 2. 'cá nhân gây quỹ'
     * - keyword: Tên dự án
     *
     * @response ProjectResource
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->okResponse(
            ProjectResource::collection($this->projectRepository->serverPaginationFilteringForApi($request->all())),
            __('Danh sách dự án'),
        );
    }
}