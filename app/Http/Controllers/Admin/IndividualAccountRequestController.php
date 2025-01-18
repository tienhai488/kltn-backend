<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\IndividualAccountReqeustResource;
use App\Models\IndividualAccountRequest;
use App\Repositories\IndividualAccountRequest\IndividualAccountRequestRepositoryInterface;
use Illuminate\Http\Request;

class IndividualAccountRequestController extends Controller
{
    public function __construct(
        protected IndividualAccountRequestRepositoryInterface $individualAccountRequestRepository,
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
            $individualAccountRequests = $this->individualAccountRequestRepository->serverPaginationFilteringForAdmin($request->all());
            return IndividualAccountReqeustResource::collection($individualAccountRequests);
        }

        return view('admin.individual_account_request.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $individualAccountRequest = $this->individualAccountRequestRepository->find($request->id);

        if (!$individualAccountRequest) {
            return to_route('admin.individual_account_request.index');
        }

        return to_route('admin.user.create')->with([
            'name' => $individualAccountRequest->name,
            'username' => $individualAccountRequest->username,
            'email' => $individualAccountRequest->email,
            'phone_number' => $individualAccountRequest->phone_number,
            'address' => $individualAccountRequest->address,
            'birth_of_date' => $individualAccountRequest->birth,
            'role' => Acl::ROLE_INDIVIDUAL,
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
    public function show(IndividualAccountRequest $individualAccountRequest)
    {
        return view('admin.individual_account_request.show', compact('individualAccountRequest'));
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