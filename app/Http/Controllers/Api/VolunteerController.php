<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Volunteer\VolunteerRequest;
use App\Http\Resources\Api\VolunteerResource;
use App\Repositories\Volunteer\VolunteerRepositoryInterface;
use App\Traits\ApiResponses;

/**
 * @tags Tình nguyện viên (Volunteer)
 */
class VolunteerController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected VolunteerRepositoryInterface $volunteerRepository,
    ) {
        //
    }

    /**
     * Lấy danh sách tình nguyện viên.
     *
     * @response VolunteerResource
     *
     * @param VolunteerRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(VolunteerRequest $request)
    {
        return $this->okResponse(
            VolunteerResource::collection($this->volunteerRepository->serverPaginationFilteringForAdmin($request->all())),
            __('Danh sách tình nguyện viên')
        );
    }
}
