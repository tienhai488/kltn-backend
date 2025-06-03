<?php

namespace App\Http\Controllers\Api;

use App\Enum\VolunteerStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Volunteer\StoreVolunteerRequest;
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
        return VolunteerResource::collection($this->volunteerRepository->serverPaginationFilteringForApi($request->all()));
        // return $this->okResponse(
        //     VolunteerResource::collection($this->volunteerRepository->serverPaginationFilteringForApi($request->all())),
        //     __('Danh sách tình nguyện viên')
        // );
    }

    /**
     * Tạo tình nguyện viên.
     *
     * @param StoreVolunteerRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreVolunteerRequest $request)
    {
        $data = $this->volunteerRepository->create(array_merge($request->validated(), [
            'status' => VolunteerStatus::PENDING->value,
        ]));

        return $this->createdResponse(
            VolunteerResource::make($data),
            __('Tạo tình nguyện viên thành công'),
        );
    }
}