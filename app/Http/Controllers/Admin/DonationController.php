<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DonationResource;
use App\Models\Donation;
use App\Repositories\Department\DepartmentRepositoryInterface;
use App\Repositories\Donation\DonationRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function __construct(
        protected DonationRepositoryInterface $donationRepository,
        protected UserRepositoryInterface $userRepository,
        protected ProjectRepositoryInterface $projectRepository,
        protected DepartmentRepositoryInterface $departmentRepository,
    ) {
        $this->middleware('permission:' . Acl::PERMISSION_DONATION_LIST)->only(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $donations = $this->donationRepository->serverPaginationFilteringForAdmin($request->all());
            return DonationResource::collection($donations);
        }

        $users = $this->userRepository->all();
        $projects = $this->projectRepository->all();
        $departments = $this->departmentRepository->all();

        return view('admin.donation.index', compact('users', 'projects', 'departments'));
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
    public function show(Donation $donation)
    {
        $donation->loadMissing('user', 'project', 'department');
        return view('admin.donation.show', compact('donation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        //
    }
}
