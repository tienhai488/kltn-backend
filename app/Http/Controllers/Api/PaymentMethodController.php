<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaymentMethod\PaymentMethodRequest;
use App\Http\Resources\Api\PaymentMethodResource;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryInterface;
use App\Traits\ApiResponses;

/**
 * @tags Phương thức thanh toán (Payment Method)
 */
class PaymentMethodController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected PaymentMethodRepositoryInterface $paymentMethodRepository,
    ) {
        //
    }

    /**
     * Lấy danh sách phương thức thanh toán.
     *
     * @response PaymentMethodResource
     *
     * @param PaymentMethodRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PaymentMethodRequest $request)
    {
        return $this->okResponse(
            PaymentMethodResource::collection($this->paymentMethodRepository->serverPaginationFilteringForAdmin($request->validated())),
            __('Danh sách phương thức thanh toán')
        );
    }
}
