<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OrginizationAccountReqeustResource;
use App\Models\OrganizationAccountRequest;
use App\Repositories\OrganizationAccountRequest\OrganizationAccountRequestRepositoryInterface;
use Illuminate\Http\Request;

class OrganizationAccountRequestController extends Controller
{
    public function __construct(
        protected OrganizationAccountRequestRepositoryInterface $organizationAccountRequestRepository,
    ) {
        $this->middleware('permission:' . Acl::PERMISSION_ACCOUNT_REQUEST_LIST)->only(['index', 'show']);
        $this->middleware('permission:' . Acl::PERMISSION_ACCOUNT_REQUEST_EDIT)->only(['update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $organizationAccountRequests = $this->organizationAccountRequestRepository->serverPaginationFilteringForAdmin($request->all());
            return OrginizationAccountReqeustResource::collection($organizationAccountRequests);
        }

        return view('admin.organization_account_request.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $organizationAccountRequest = $this->organizationAccountRequestRepository->find($request->id);

        if (!$organizationAccountRequest) {
            return to_route('admin.organization_account_request.index');
        }

        return to_route('admin.user.create')->with([
            'name' => $organizationAccountRequest->name,
            'username' => $organizationAccountRequest->username,
            'email' => $organizationAccountRequest->representative_email,
            'phone_number' => $organizationAccountRequest->representative_phone_number,
            'address' => $organizationAccountRequest->address,
            'role' => Acl::ROLE_ORGANIZATION,
        ]);
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
    public function show(OrganizationAccountRequest $organizationAccountRequest)
    {
        return view('admin.organization_account_request.show', compact('organizationAccountRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}