<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Donation\DonationRequest;
use App\Http\Resources\Api\DonationResource;
use App\Repositories\Donation\DonationRepositoryInterface;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            DonationResource::collection($this->donationRepository->serverPaginationFilteringForAdmin($request->only(['page', 'limit']))),
            __('Danh sách quyên góp')
        );
    }
}