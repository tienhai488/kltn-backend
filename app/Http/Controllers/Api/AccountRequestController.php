<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AccountRequest\IndividualRequest;
use App\Http\Requests\Api\AccountRequest\OrganizationRequest;
use App\Repositories\IndividualAccountRequest\IndividualAccountRequestRepositoryInterface;
use App\Repositories\OrganizationAccountRequest\OrganizationAccountRequestRepositoryInterface;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

/**
 * @tags Yêu cầu tài khoản (Account Request)
 */
class AccountRequestController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected OrganizationAccountRequestRepositoryInterface $organizationAccountRequestRepository,
        protected IndividualAccountRequestRepositoryInterface $individualAccountRequestRepository,
    ) {
        //
    }

    /**
     * Tổ chức.
     *
     * Thêm mới yêu cầu tài khoản cho tổ chức.
     *
     * @response array{
     *   message: string,
     *   data: array{
     *    status: boolean,
     *   },
     * }
     *
     * @param OrganizationRequest $request
     * @return JsonResponse
     */
    public function organization(OrganizationRequest $request)
    {
        return $this->organizationAccountRequestRepository->create($request->validated()) ?
            $this->okResponse(
                ['status' => true],
                __('Thêm mới yêu cầu tài khoản cho tổ chức thành công.')
            )
            : $this->errorResponse(
                ['status' => false],
                __('Thêm mới yêu cầu tài khoản cho tổ chức thất bại.'),
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
    }

    /**
     * Cá nhân.
     *
     * Thêm mới yêu cầu tài khoản cho cá nhân.
     *
     * @response array{
     *   message: string,
     *   data: array{
     *    status: boolean,
     *   },
     * }
     *
     * @param IndividualRequest $request
     * @return JsonResponse
     */
    public function individual(IndividualRequest $request)
    {
        return $this->individualAccountRequestRepository->create($request->validated()) ?
            $this->okResponse(
                ['status' => true],
                __('Thêm mới yêu cầu tài khoản cho cá nhân thành công.')
            )
            : $this->errorResponse(
                ['status' => false],
                __('Thêm mới yêu cầu tài khoản cho cá nhân thất bại.'),
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
    }
}
