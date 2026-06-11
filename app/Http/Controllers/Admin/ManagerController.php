<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreManagerRequest;
use App\Http\Requests\Admin\UpdateManagerRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagerController extends Controller
{
    public function __construct(
        private UserRepository $users,
        private UserManagementService $userService,
    ) {}

    public function index(Request $request): View
    {
        $filters = array_merge($request->only(['search', 'status', 'department']), ['role' => 'manager']);
        $managers = $this->users->paginateAll($filters);

        return view('admin.managers.index', compact('managers'));
    }

    public function create(): View
    {
        return view('admin.managers.create');
    }

    public function store(StoreManagerRequest $request): RedirectResponse
    {
        $this->userService->create($request->validated(), 'manager');

        return redirect()->route('admin.managers.index')->with('success', 'Manager created successfully.');
    }

    public function edit(User $manager): View
    {
        abort_unless($manager->role === 'manager', 404);

        return view('admin.managers.edit', compact('manager'));
    }

    public function update(UpdateManagerRequest $request, User $manager): RedirectResponse
    {
        abort_unless($manager->role === 'manager', 404);
        $this->userService->update($manager, $request->validated());

        return redirect()->route('admin.managers.index')->with('success', 'Manager updated successfully.');
    }

    public function destroy(User $manager): RedirectResponse
    {
        abort_unless($manager->role === 'manager', 404);
        $this->userService->delete($manager);

        return redirect()->route('admin.managers.index')->with('success', 'Manager deleted.');
    }

    public function toggleStatus(User $manager): RedirectResponse
    {
        abort_unless($manager->role === 'manager', 404);
        $this->userService->toggleStatus($manager);

        return back()->with('success', 'Status updated.');
    }

    public function resetPassword(Request $request, User $manager): RedirectResponse
    {
        abort_unless($manager->role === 'manager', 404);
        $request->validate(['password' => 'required|string|min:8|confirmed']);
        $this->userService->resetPassword($manager, $request->password);

        return back()->with('success', 'Password reset successfully.');
    }
}
