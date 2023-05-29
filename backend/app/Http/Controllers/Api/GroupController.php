<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\User;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // retrieve groups resources with their associated users
        $groups = Group::with('users')->paginate(20);

        // return a collection of the resources
        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        // Create a new group record with the validated request data
        $group = Group::create($request->validated());

        // return a resource of the newly created group record
        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        // Load the associated users of the group
        $group->load(['users' => function ($query) {
            $query->paginate(5);
        }]);

        // Return a resource of th group record
        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        // Update group record with the validated request data
        $group->update($request->validated());

        // return a resource of the updated group record
        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        // Delete the group record
        $group->delete();

        // return an empty response
        return response()->noContent();
    }

    /**
     * Dettach the specified user from group.
     */
    public function detach(Group $group, User $user)
    {
        $group->users()->detach($user);
        return response()->noContent();
    }

    /**
     * attach the specified user from group.
     */
    public function attach(Group $group, User $user)
    {
        $group->users()->attach($user);
        return response()->noContent();
    }
}
