<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Enum\CategoryStatus;
use App\Enum\NotificationType;
use App\Enum\VolunteerStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Project\StoreProjectRequest;
use App\Http\Requests\Admin\Project\UpdateProjectRequest;
use App\Http\Resources\Admin\ProjectResource;
use App\Models\Project;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectRepositoryInterface $projectRepository,
        protected UserRepositoryInterface $userRepository,
        protected CategoryRepositoryInterface $categoryRepository,
    ) {
        $this->middleware('permission:' . Acl::PERMISSION_PROJECT_LIST)->only('index');
        $this->middleware('permission:' . Acl::PERMISSION_PROJECT_ADD)->only(['create', 'store']);
        $this->middleware('permission:' . Acl::PERMISSION_PROJECT_EDIT)->only(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $projects = $this->projectRepository->serverPaginationFilteringForAdmin($request->all());
            return ProjectResource::collection($projects);
        }

        $users = $this->userRepository->all();
        $categories = $this->categoryRepository->all();

        return view('admin.project.index', compact('users', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryRepository->advancedGet([
            'conditions' => [
                'where' => [
                    'status' => CategoryStatus::ON,
                ],
            ],
        ]);

        return view('admin.project.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $this->projectRepository->create($request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Thêm mới dự án thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Thêm mới dự án thất bại.'));

        return to_route('admin.project.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project
            ->loadMissing('category', 'user', 'donations', 'volunteers')
            ->loadCount(['volunteers' => function ($query) {
                $query->where('status', '!=', VolunteerStatus::CANCELED);
            }])
            ->loadSum('donations', 'amount');

        return view('admin.project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $categories = $this->categoryRepository->advancedGet([
            'conditions' => [
                'where' => [
                    'status' => CategoryStatus::ON,
                ],
            ],
        ]);

        return view('admin.project.edit', compact('project', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        // return $request->related_images;
        $this->projectRepository->update($project, $request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chỉnh sửa dự án thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Chỉnh sửa dự án thất bại.'));

        return to_route('admin.project.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
