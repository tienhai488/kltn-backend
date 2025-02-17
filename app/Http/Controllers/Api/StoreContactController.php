<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contact\StoreContractRequest;
use App\Repositories\Contact\ContactRepository;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

/**
 * @tags Liên hệ (Contact)
 */
class StoreContactController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected ContactRepository $contactRepository,
    ) {
        //
    }

    /**
     * Liên hệ.
     *
     * Thêm mới liên hệ được gửi từ người dùng.
     *
     * @response array{
     *   message: string,
     *   data: array{
     *    status: boolean,
     *   },
     * }
     *
     * @param StoreContractRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreContractRequest $request)
    {
        $contact = $this->contactRepository->create($request->validated());

        return $contact ?
            $this->okResponse(
                ['status' => true],
                __('Thêm mới liên hệ thành công.')
            )
            : $this->errorResponse(
                ['status' => false],
                __('Thêm mới liên hệ thất bại.'),
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
    }
}