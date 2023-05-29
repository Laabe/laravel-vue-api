<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('groups')->paginate(20);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $userData = array_merge(
            $request->validated(),
            ['password' => bcrypt('password')]
        );
        $user = User::create($userData);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Load the associated groups of the user
        $user->load('groups');

        // Return the user record resource
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    /**
     * Dettach the specified group from user.
     */
    public function detach(User $user, Group $group)
    {
        $user->groups()->detach($group);
        return response()->noContent();
    }

    /**
     * attach the specified group from user.
     */
    public function attach(User $user, Group $group)
    {
        $user->groups()->syncWithoutDetaching($group);
        return response()->noContent();
    }
}
