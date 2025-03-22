<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UpdateAvatarRequest;
use App\Http\Requests\Api\User\UpdateProfileRequest;
use App\Http\Requests\Api\User\UserRequest;
use App\Http\Resources\Api\UserResource;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

/**
 * @tags Người dùng (User)
 */
class UserController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {
        //
    }

    /**
     * Lấy danh sách người dùng.
     *
     * @response UserResource
     *
     * @param UserRequest $request
     *
     * @return JsonResponse
     */
    public function index(UserRequest $request)
    {
        return $this->okResponse(
            UserResource::collection($this->userRepository->serverPaginationFilteringForApi($request->all())),
            __('Danh sách người dùng'),
        );
    }

    /**
     * Thông tin người dùng.
     *
     * Thông tin người dùng đăng nhập vào hệ thống.
     *
     * @response UserResource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return $this->okResponse(new UserResource(
            $this->userRepository->advancedGetFirst([
                'conditions' => [
                    'where' => [
                        ['id', '=', auth()->id()],
                    ],
                ],
                'with_count' => [
                    'projects',
                    'donations',
                    'volunteers_without_canceled',
                ],
                'with_sums' => [
                    [
                        'relation' => 'donations',
                        'column' => 'amount',
                    ],
                ],
                'with' => ['projects.donations'],
            ]),
        ));
    }

    /**
     * Chỉnh sửa thông tin người dùng.
     *
     * Chỉnh sửa thông tin người dùng đăng nhập vào hệ thống.
     *
     * @response array{
     *   message: string,
     *   data: array{
     *    status: boolean,
     *   },
     * }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        return $this->userRepository->updateProfileForApi(auth()->user(), $request->validated()) ?
            $this->okResponse(
                ['status' => true],
                __('Chỉnh sửa thông tin người dùng thành công.'),
            )
            : $this->errorResponse(
                ['status' => false],
                __('Chỉnh sửa thông tin người dùng thất bại.'),
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            );
    }

    /**
     * Chỉnh sửa ảnh đại diện người dùng.
     *
     * Chỉnh sửa ảnh đại diện của người dùng đăng nhập vào hệ thống.
     *
     * @response array{
     *   message: string,
     * }
     *
     * @param UpdateAvatarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvatar(UpdateAvatarRequest $request)
    {
        if ($this->userRepository->updateAvatar(auth()->user(), $request->validated())) {
            return $this->okResponse(null, __('Chỉnh sửa ảnh đại diện thành công.'));
        }

        return $this->errorResponse(__('Chỉnh sửa ảnh đại diện thất bại.'));
    }
}
