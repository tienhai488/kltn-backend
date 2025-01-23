<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\VolunteerResource;
use App\Models\Volunteer;
use App\Repositories\Department\DepartmentRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Volunteer\VolunteerRepositoryInterface;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function __construct(
        protected VolunteerRepositoryInterface $volunteerRepository,
        protected UserRepositoryInterface $userRepository,
        protected ProjectRepositoryInterface $projectRepository,
        protected DepartmentRepositoryInterface $departmentRepository,
    ) {
        $this->middleware('permission:' . Acl::PERMISSION_VOLUNTEER_LIST)->only(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $volunteers = $this->volunteerRepository->serverPaginationFilteringForAdmin($request->all());
            return VolunteerResource::collection($volunteers);
        }

        $users = $this->userRepository->all();
        $projects = $this->projectRepository->all();
        $departments = $this->departmentRepository->all();

        return view('admin.volunteer.index', compact('users', 'projects', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Volunteer $volunteer)
    {
        $volunteer->loadMissing('user', 'project', 'department');
        return view('admin.volunteer.show', compact('volunteer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Volunteer $volunteer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Volunteer $volunteer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Volunteer $volunteer)
    {
        //
    }
}
