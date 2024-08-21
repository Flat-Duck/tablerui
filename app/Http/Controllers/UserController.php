<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', User::class);

        $search = $request->get('search', '');

        $users = User::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', User::class);

        return view('app.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'abc3' => ['image', 'max:1024'],
            'abc4' => ['file', 'max:1024'],
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'email_verified_at' => ['nullable', 'date'],
        ]);

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

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user): View
    {
        $this->authorize('view', $user);

        return view('app.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user): View
    {
        $this->authorize('update', $user);

        return view('app.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($user),
                'email',
            ],
            'password' => ['nullable'],
            'abc3' => ['image', 'max:1024'],
            'abc4' => ['file', 'max:1024'],
            'name' => ['required', 'max:255', 'string'],
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($user),
                'email',
            ],
            'email_verified_at' => ['nullable', 'date'],
        ]);

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

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        if ($user->abc3) {
            Storage::delete($user->abc3);
        }

        if ($user->abc4) {
            Storage::delete($user->abc4);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
