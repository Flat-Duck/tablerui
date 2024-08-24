<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function index(Request $request): UserCollection
    {
        $this->authorize('view-any', User::class);

        $search = $request->get('search', '');

        $users = User::search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(UserStoreRequest $request): UserResource
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        if (!empty($validated['abc10'])) {
            $validated['abc10'] = Hash::make($validated['abc10']);
        }

        if ($request->hasFile('abc3')) {
            $validated['abc3'] = $request->file('abc3')->store('public');
        }

        if ($request->hasFile('abc4')) {
            $validated['abc4'] = $request->file('abc4')->store('public');
        }

        $user = User::create($validated);

        $user->syncRoles($request->roles);

        return new UserResource($user);
    }

    public function show(Request $request, User $user): UserResource
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $this->authorize('update', $user);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        if (empty($validated['abc10'])) {
            unset($validated['abc10']);
        } else {
            $validated['abc10'] = Hash::make($validated['abc10']);
        }

        if ($request->hasFile('abc3')) {
            if ($user->abc3) {
                Storage::delete($user->abc3);
            }

            $validated['abc3'] = $request->file('abc3')->store('public');
        }

        if ($request->hasFile('abc4')) {
            if ($user->abc4) {
                Storage::delete($user->abc4);
            }

            $validated['abc4'] = $request->file('abc4')->store('public');
        }

        $user->update($validated);

        $user->syncRoles($request->roles);

        return new UserResource($user);
    }

    public function destroy(Request $request, User $user): Response
    {
        $this->authorize('delete', $user);

        if ($user->abc3) {
            Storage::delete($user->abc3);
        }

        if ($user->abc4) {
            Storage::delete($user->abc4);
        }

        $user->delete();

        return response()->noContent();
    }
}
