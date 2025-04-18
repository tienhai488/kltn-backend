<?php

namespace App\Http\Controllers\Member;

use App\Enum\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Member\User\UpdatePasswordRequest;
use App\Http\Requests\Member\User\UpdateProfileRequest;
use App\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {
        //
    }

    /**
     * Display the specified resource of the logged in use
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function myProfile()
    {
        return view('member.user.profile.my_profile');
    }

    /**
     * Update the profile of the logged-in user.
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->userRepository->updateProfile(auth()->user(), $request->validated()) ?
            session()->flash(NotificationType::SUCCESS->value, __('Chỉnh sửa thông tin cá nhân thành công.'))
            : session()->flash(NotificationType::ERROR->value, __('Chỉnh sửa thông tin cá nhân thất bại.'));

        return redirect()->back();
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->userRepository->updatePassword($request->user(), $request->validated()) ?
            session()->flash(NotificationType::SUCCESS->value, __('Đặt lại mật khẩu thành công.'))
            : session()->flash(NotificationType::ERROR->value, __('Đặt lại mật khẩu thất bại.'));

        return to_route('admin.user.my_profile', ['tab' => 'password']);
    }
}
