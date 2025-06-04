<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Donation\DonationRequest;
use App\Http\Requests\Api\Donation\StoreDonationRequest;
use App\Http\Resources\Api\DonationResource;
use App\Repositories\Donation\DonationRepositoryInterface;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

/**
 * @tags Quyên góp (Donation)
 */
class DonationController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected DonationRepositoryInterface $donationRepository,
    ) {
        //
    }

    /**
     * Lấy danh sách quyên góp.
     *
     * @response DonationResource
     *
     * @param DonationRequest $request
     *
     * @return JsonResponse
     */
    public function index(DonationRequest $request)
    {
        return $this->okResponse(
            DonationResource::collection($this->donationRepository->serverPaginationFilteringForApi($request->all())),
            __('Danh sách quyên góp')
        );
    }

    /**
     * Tạo quyên góp.
     *
     * @param StoreDonationRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreDonationRequest $request)
    {
        $donation = $this->donationRepository->create($request->validated());

        return $this->createdResponse(DonationResource::make($donation), __('Tạo quyên góp thành công'));
    }
}
