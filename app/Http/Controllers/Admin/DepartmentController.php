<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Enum\DepartmentStatus;
use App\Enum\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Department\StoreDepartmentRequest;
use App\Http\Requests\Admin\Department\UpdateDepartmentRequest;
use App\Http\Resources\Admin\DepartmentResource;
use App\Models\Department;
use App\Repositories\Department\DepartmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
    public function __construct(
        protected DepartmentRepositoryInterface $departmentRepository,
    ) {
        $this->middleware('permission:' . Acl::PERMISSION_DEPARTMENT_LIST)->only('index');
        $this->middleware('permission:' . Acl::PERMISSION_DEPARTMENT_ADD)->only(['create', 'store']);
        $this->middleware('permission:' . Acl::PERMISSION_DEPARTMENT_EDIT)->only(['edit', 'update']);
        $this->middleware('permission:' . Acl::PERMISSION_DEPARTMENT_DELETE)->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $departments = $this->departmentRepository->serverPaginationFilteringForAdmin($request->all());
            return DepartmentResource::collection($departments);
        }

        return view('admin.department.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = DepartmentStatus::options(true);

        return view('admin.department.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $this->departmentRepository->create($request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Thêm mới phòng ban thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Thêm mới phòng ban thất bại.'));

        return to_route('admin.department.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $statuses = DepartmentStatus::options(true);

        return view('admin.department.edit', compact('department', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $this->departmentRepository->update($department, $request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chình sửa phòng ban thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Chình sửa phòng ban thất bại.'));

        return to_route('admin.department.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        if ($this->departmentRepository->destroy($department)) {
            return response()->json([
                'message' => __('Xóa phòng ban thành công.'),
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => __('Xóa phòng ban thất bại.'),
        ], Response::HTTP_BAD_REQUEST);
    }
}
