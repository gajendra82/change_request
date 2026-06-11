<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private UserRepository $users,
        private ClientRepository $clients,
    ) {}

    public function index(Request $request): View
    {
        $users = $this->users->paginateAll($request->only(['search', 'role', 'client_id', 'status', 'department']));
        $clients = $this->clients->allActive();

        return view('admin.users.index', compact('users', 'clients'));
    }

    public function show(User $user): View
    {
        $user->load(['client', 'changeRequests', 'developedTimelines', 'activityLogs']);
        $loginHistory = ActivityLog::where('user_id', $user->id)
            ->whereIn('action', ['user_login', 'user_logout'])
            ->latest()->limit(20)->get();

        return view('admin.users.show', compact('user', 'loginHistory'));
    }
}
