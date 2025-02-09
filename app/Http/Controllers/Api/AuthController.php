<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @tags Xác thực người dùng (Authentication)
 */
class AuthController extends Controller
{
    use AuthenticatesUsers, ApiResponses;

    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {
        //
    }

    /**
     * Đăng nhập.
     *
     * Người dùng đăng nhập vào hệ thống.
     *
     * @response array{
     *   message: string,
     *   data: UserResource,
     * }
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if ($this->attemptLogin($request)) {
            $user = auth()->user();

            $token = $user->createToken('API Token')->plainTextToken;

            return $this->okResponse([
                'token' => $token,
                'user' => new UserResource($user),
            ]);
        }

        return $this->unauthorizedResponse([], trans('auth.failed'));
    }

    /**
     * Đăng kí.
     *
     * Người dùng đăng kí tài khoản hệ thống.
     *
     * @response array{
     *   message: string,
     *   data: UserResource,
     * }
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        return $this->userRepository->register($request->validated()) ?
            $this->okResponse(
                ['status' => true],
                __('Đăng kí tài khoản thành công.')
            )
            : $this->errorResponse(
                ['status' => false],
                __('Đăng kí tài khoản thất bại.'),
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
    }

    /**
     * Đăng xuất.
     *
     * Người dùng đăng xuất khỏi hệ thống.
     *
     * @response array{
     *   message: string,
     * }
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->okResponse([], __('Đăng xuất thành công'));
    }
}