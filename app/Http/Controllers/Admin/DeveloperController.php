<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDeveloperRequest;
use App\Http\Requests\Admin\UpdateDeveloperRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeveloperController extends Controller
{
    public function __construct(
        private UserRepository $users,
        private UserManagementService $userService,
    ) {}

    public function index(Request $request): View
    {
        $filters = array_merge($request->only(['search', 'status', 'department']), ['role' => 'developer']);
        $developers = $this->users->paginateAll($filters);

        return view('admin.developers.index', compact('developers'));
    }

    public function create(): View
    {
        return view('admin.developers.create');
    }

    public function store(StoreDeveloperRequest $request): RedirectResponse
    {
        $this->userService->create($request->validated(), 'developer');

        return redirect()->route('admin.developers.index')->with('success', 'Developer created successfully.');
    }

    public function edit(User $developer): View
    {
        abort_unless($developer->role === 'developer', 404);

        return view('admin.developers.edit', compact('developer'));
    }

    public function update(UpdateDeveloperRequest $request, User $developer): RedirectResponse
    {
        abort_unless($developer->role === 'developer', 404);
        $this->userService->update($developer, $request->validated());

        return redirect()->route('admin.developers.index')->with('success', 'Developer updated successfully.');
    }

    public function destroy(User $developer): RedirectResponse
    {
        abort_unless($developer->role === 'developer', 404);
        $this->userService->delete($developer);

        return redirect()->route('admin.developers.index')->with('success', 'Developer deleted.');
    }

    public function toggleStatus(User $developer): RedirectResponse
    {
        abort_unless($developer->role === 'developer', 404);
        $this->userService->toggleStatus($developer);

        return back()->with('success', 'Status updated.');
    }

    public function resetPassword(Request $request, User $developer): RedirectResponse
    {
        abort_unless($developer->role === 'developer', 404);
        $request->validate(['password' => 'required|string|min:8|confirmed']);
        $this->userService->resetPassword($developer, $request->password);

        return back()->with('success', 'Password reset successfully.');
    }
}
