<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientUserRequest;
use App\Http\Requests\Admin\UpdateClientUserRequest;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Repositories\UserRepository;
use App\Services\UserManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientUserController extends Controller
{
    public function __construct(
        private UserRepository $users,
        private ClientRepository $clients,
        private UserManagementService $userService,
    ) {}

    public function index(Request $request): View
    {
        $filters = array_merge($request->only(['search', 'status']), ['role' => 'client']);
        if ($request->filled('client_id')) {
            $filters['client_id'] = $request->client_id;
        }
        $clientUsers = $this->users->paginateAll($filters);
        $clients = $this->clients->allActive();

        return view('admin.client-users.index', compact('clientUsers', 'clients'));
    }

    public function create(): View
    {
        $clients = $this->clients->allActive();

        return view('admin.client-users.create', compact('clients'));
    }

    public function store(StoreClientUserRequest $request): RedirectResponse
    {
        $this->userService->create($request->validated(), 'client');

        return redirect()->route('admin.client-users.index')->with('success', 'Client user created successfully.');
    }

    public function edit(User $client_user): View
    {
        abort_unless($client_user->role === 'client', 404);
        $clients = $this->clients->allActive();

        return view('admin.client-users.edit', compact('client_user', 'clients'));
    }

    public function update(UpdateClientUserRequest $request, User $client_user): RedirectResponse
    {
        abort_unless($client_user->role === 'client', 404);
        $this->userService->update($client_user, $request->validated());

        return redirect()->route('admin.client-users.index')->with('success', 'Client user updated successfully.');
    }

    public function destroy(User $client_user): RedirectResponse
    {
        abort_unless($client_user->role === 'client', 404);
        $this->userService->delete($client_user);

        return redirect()->route('admin.client-users.index')->with('success', 'Client user deleted.');
    }

    public function toggleStatus(User $client_user): RedirectResponse
    {
        abort_unless($client_user->role === 'client', 404);
        $this->userService->toggleStatus($client_user);

        return back()->with('success', 'Status updated.');
    }

    public function resetPassword(Request $request, User $client_user): RedirectResponse
    {
        abort_unless($client_user->role === 'client', 404);
        $request->validate(['password' => 'required|string|min:8|confirmed']);
        $this->userService->resetPassword($client_user, $request->password);

        return back()->with('success', 'Password reset successfully.');
    }
}
