<?php

namespace App\Http\Controllers\Member;

use App\Acl\Acl;
use App\Enum\CategoryStatus;
use App\Enum\NotificationType;
use App\Enum\VolunteerStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Project\StoreProjectRequest;
use App\Http\Requests\Member\Project\UpdateProjectRequest;
use App\Http\Resources\Member\ProjectResource;
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

        $categories = $this->categoryRepository->all();

        return view('member.project.index', compact('categories'));
    }

    /**
     * Display a statistic of the resource.
     */
    public function statistic(Request $request, Project $project)
    {
        if ($project->user_id != auth()->id()) {
            abort(404);
        }

        $users = $this->userRepository->all();
        $categories = $this->categoryRepository->all();
        $projects = $this->projectRepository->advancedGet([
            'conditions' => [
                'where' => [
                    'user_id' => $project->user_id,
                ],
            ],
        ]);

        return view(
            'member.project.statistic',
            compact(
                'project',
                'categories',
                'projects',
                'users',
            ),
        );
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

        return view('member.project.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $this->projectRepository->create($request->validated()) ?
            session()->flash(NotificationType::SUCCESS->value, __('Thêm mới dự án thành công.'))
            : session()->flash(NotificationType::ERROR->value, __('Thêm mới dự án thất bại.'));

        return to_route('member.project.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        if ($project->user_id != auth()->id()) {
            abort(404);
        }

        $project
            ->loadMissing('category', 'user', 'donations', 'volunteers')
            ->loadCount(['volunteers' => function ($query) {
                $query->where('status', '!=', VolunteerStatus::CANCELED);
            }])
            ->loadSum('donations', 'amount');

        return view('member.project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        if ($project->user_id != auth()->id()) {
            abort(404);
        }

        $categories = $this->categoryRepository->advancedGet([
            'conditions' => [
                'where' => [
                    'status' => CategoryStatus::ON,
                ],
            ],
        ]);

        return view('member.project.edit', compact('project', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        if ($project->user_id != auth()->id()) {
            abort(404);
        }

        // return $request->related_images;
        $this->projectRepository->update($project, $request->validated()) ?
            session()->flash(NotificationType::SUCCESS->value, __('Chỉnh sửa dự án thành công.'))
            : session()->flash(NotificationType::ERROR->value, __('Chỉnh sửa dự án thất bại.'));

        return to_route('member.project.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
