<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Member\DonationResource;
use App\Http\Resources\Member\ProjectResource;
use App\Http\Resources\Member\VolunteerResource;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Donation\DonationRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Volunteer\VolunteerRepositoryInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected ProjectRepositoryInterface $projectRepository,
        protected DonationRepositoryInterface $donationRepository,
        protected VolunteerRepositoryInterface $volunteerRepository,
        protected UserRepositoryInterface $userRepository,
        protected CategoryRepositoryInterface $categoryRepository,
    ) {
        // Constructor logic can be added here if needed
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $user->load([
            'projects' => function ($query) {
                $query->with('donations');
            },
            'donations',
            'volunteers_without_canceled',
        ]);
        $users = $this->userRepository->getUsers();
        $members = $this->userRepository->getMembers();

        $categories = $this->categoryRepository->all();
        $projects = $this->projectRepository->advancedGet([
            'conditions' => [
                'where' => [
                    'user_id' => $user->id,
                ],
            ]
        ]);

        return view('member.dashboard.index', compact(
            'user',
            'users',
            'members',
            'projects',
            'categories',
        ));
    }

    /**
     * Get list of projects.
     */
    public function projects(Request $request)
    {
        if ($request->ajax()) {
            $projects = $this->projectRepository->serverPaginationFilteringForStatistic($request->all());
            return ProjectResource::collection($projects);
        }

        abort(404);
    }

    /**
     * Get list of donations.
     */
    public function donations(Request $request)
    {
        if ($request->ajax()) {
            $donations = $this->donationRepository->serverPaginationFilteringForStatistic($request->all());
            return DonationResource::collection($donations);
        }

        abort(404);
    }

    /**
     * Get list of volunteers.
     */
    public function volunteers(Request $request)
    {
        if ($request->ajax()) {
            $volunteers = $this->volunteerRepository->serverPaginationFilteringForStatistic($request->all());
            return VolunteerResource::collection($volunteers);
        }

        abort(404);
    }
}