<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use App\Repositories\ClientRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectRepository $projects,
        private ClientRepository $clients,
        private UserRepository $users,
        private ActivityLogService $activityLog,
    ) {}

    public function index(Request $request): View
    {
        $projects = $this->projects->paginate($request->only(['search', 'client_id', 'status']));
        $clients = $this->clients->allActive();

        return view('admin.projects.index', compact('projects', 'clients'));
    }

    public function create(): View
    {
        $clients = $this->clients->allActive();
        $managers = $this->users->managers();

        return view('admin.projects.create', compact('clients', 'managers'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $project = Project::create($request->validated());
        $this->activityLog->log('project_created', "Created project: {$project->name}", $project);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project): View
    {
        $clients = $this->clients->allActive();
        $managers = $this->users->managers();

        return view('admin.projects.edit', compact('project', 'clients', 'managers'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());
        $this->activityLog->log('project_updated', "Updated project: {$project->name}", $project);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->activityLog->log('project_deleted', "Deleted project: {$project->name}", $project);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }
}
