<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Enum\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function __construct(
        protected RoleRepositoryInterface $roleRepository,
        protected PermissionRepositoryInterface $permissionRepository,
    ) {
        $this->middleware('permission:' . Acl::PERMISSION_ROLE_LIST)->only('index');
        $this->middleware('permission:' . Acl::PERMISSION_ROLE_ADD)->only(['create', 'store']);
        $this->middleware('permission:' . Acl::PERMISSION_ROLE_EDIT)->only(['edit', 'update']);
        $this->middleware('permission:' . Acl::PERMISSION_ROLE_DELETE)->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = $this->roleRepository->allRolesWithPermissions();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permissionRepository->all();
        $groups = config('permission-groups');
        $groupedPermissions = collect($permissions)->groupBy(function ($permission) use ($groups) {
            foreach ($groups as $group => $keywords) {
                foreach ($keywords as $keyword) {
                    if (Str::contains($permission->name, $keyword)) {
                        return $group;
                    }
                }
            }
            return 'Khác';
        });

        return view('admin.role.create', compact('groupedPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $this->roleRepository->create($request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('success.role.store'))
            :
            session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('error.role.store'));

        return to_route('admin.role.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Spatie\Permission\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = $this->permissionRepository->all();
        $role->load('permissions');
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $groups = config('permission-groups');
        $groupedPermissions = collect($permissions)->groupBy(function ($permission) use ($groups) {
            foreach ($groups as $group => $keywords) {
                foreach ($keywords as $keyword) {
                    if (Str::contains($permission->name, $keyword)) {
                        return $group;
                    }
                }
            }
            return 'Khác';
        });

        return view('admin.role.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Spatie\Permission\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roleRepository->update($role, $request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('success.role.update'))
            :
            session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('error.role.update'));

        return to_route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Spatie\Permission\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($this->roleRepository->destroy($role))
            return response()->json([
                'message' => __('success.delete'),
            ], Response::HTTP_OK);
        return response()->json([
            'message' => __('error.delete'),
        ], Response::HTTP_BAD_REQUEST);
    }
}
