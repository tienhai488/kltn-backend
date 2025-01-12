<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ContactResource;
use App\Models\Contact;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        protected ContactRepositoryInterface $contactRepository,
        protected UserRepositoryInterface $userRepository,
    ) {
        $this->middleware('permission:' . Acl::PERMISSION_CONTACT_LIST)->only(['index', 'show']);
        $this->middleware('permission:' . Acl::PERMISSION_CONTACT_EDIT)->only(['update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $contacts = $this->contactRepository->serverPaginationFilteringForAdmin($request->all());
            return ContactResource::collection($contacts);
        }

        $users = $this->userRepository->all();
        return view('admin.contact.index', compact('users'));
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
    public function show(Contact $contact)
    {
        $contact->loadMissing('user');

        return view('admin.contact.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
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