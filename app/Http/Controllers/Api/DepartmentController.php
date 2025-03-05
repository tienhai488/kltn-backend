<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Department\DepartmentRequest;
use App\Http\Resources\Api\DepartmentResource;
use App\Repositories\Department\DepartmentRepositoryInterface;
use App\Traits\ApiResponses;

/**
 * @tags Phòng ban (Department)
 */
class DepartmentController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected DepartmentRepositoryInterface $departmentRepository,
    ) {
        //
    }

    /**
     * Lấy danh sách phòng ban.
     *
     * @response DepartmentResource
     *
     * @param DepartmentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(DepartmentRequest $request)
    {
        return $this->okResponse(
            DepartmentResource::collection($this->departmentRepository->serverPaginationFilteringForAdmin($request->all())),
            __('Danh sách phòng ban')
        );
    }
}
