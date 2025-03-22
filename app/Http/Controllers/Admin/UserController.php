<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Enum\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdatePasswordRequest;
use App\Http\Requests\Admin\User\UpdateProfileRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected RoleRepositoryInterface $roleRepository,
    ) {
        $this->middleware('permission:' . Acl::PERMISSION_USER_LIST)->only('index');
        $this->middleware('permission:' . Acl::PERMISSION_USER_ADD)->only(['create', 'store']);
        $this->middleware('permission:' . Acl::PERMISSION_USER_EDIT)->only(['edit', 'update']);
        $this->middleware('permission:' . Acl::PERMISSION_USER_DELETE)->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = $this->userRepository->serverPaginationFilteringForAdmin($request->all());
            return UserResource::collection($users);
        }

        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->roleRepository->advancedGet([
            'conditions' => [
                'where_not_in' => [
                    'name' => [Acl::ROLE_SUPER_ADMIN],
                ],
            ],
        ]);

        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->userRepository->create($request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Thêm mới người dùng thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Thêm mới người dùng thất bại.'));

        return to_route('admin.user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Display the specified resource of the logged in use
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function myProfile()
    {
        return view('admin.user.profile.my_profile');
    }

    /**
     * Update the profile of the logged-in user.
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->userRepository->update(auth()->user(), $request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chỉnh sửa thông tin cá nhân thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Chỉnh sửa thông tin cá nhân thất bại.'));

        return redirect()->back();
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->userRepository->updatePassword($request->user(), $request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Đặt lại mật khẩu thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Đặt lại mật khẩu thất bại.'));

        return to_route('admin.user.my_profile', ['tab' => 'password']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $userRoles = $user->roles->pluck('id')->toArray();
        $roles = $this->roleRepository->advancedGet([
            'conditions' => [
                'where_not_in' => [
                    'name' => [Acl::ROLE_SUPER_ADMIN],
                ],
            ],
        ]);
        $userProfile = $user->userProfile;

        return view('admin.user.edit', compact(
            'roles',
            'user',
            'userRoles',
            'userProfile',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userRepository->update($user, $request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chỉnh sửa người dùng thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Chỉnh sửa người dùng thất bại.'));

        return to_route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($this->userRepository->destroy($user))
            return response()->json([
                'message' => __('Xóa người dùng thành công.'),
            ], Response::HTTP_OK);
        return response()->json([
            'message' => __('Xóa người dùng thất bại.'),
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Toggle the status of a user between active and locked.
     */
    public function toggleStatus(User $user)
    {
        return $this->userRepository->toggleStatus($user);
    }
}
