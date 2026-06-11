<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ChangeRequest;
use App\Models\ChangeRequestTimeline;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_clients' => Client::count(),
            'total_client_users' => User::where('role', 'client')->count(),
            'total_developers' => User::where('role', 'developer')->count(),
            'total_managers' => User::where('role', 'manager')->count(),
            'total_projects' => Project::count(),
            'open_change_requests' => ChangeRequest::whereIn('status', ['submitted', 'timeline_added'])->count(),
            'pending_approvals' => ChangeRequestTimeline::where('manager_status', 'pending')->count(),
            'completed_requests' => ChangeRequest::where('status', 'completed')->count(),
        ];

        $chartData = $this->buildChartData();

        $recentChangeRequests = ChangeRequest::with(['client', 'project', 'timeline'])
            ->latest()->limit(8)->get();

        $pendingApprovals = ChangeRequestTimeline::with(['changeRequest.client', 'developer'])
            ->where('manager_status', 'pending')->latest()->limit(6)->get();

        $recentActivities = ActivityLog::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'chartData', 'recentChangeRequests', 'pendingApprovals', 'recentActivities'));
    }

    private function buildChartData(): array
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i));
        }

        $monthlyLabels = $months->map(fn ($m) => $m->format('M Y'))->all();
        $monthlyValues = $months->map(fn ($m) => ChangeRequest::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count())->all();

        $clientWise = Client::all()->map(function ($client) {
            $userIds = User::where('client_id', $client->id)->pluck('id');
            $crCount = ChangeRequest::whereIn('client_id', $userIds)->count();

            return ['name' => $client->company_name, 'count' => $crCount];
        })->sortByDesc('count')->take(8)->values();

        $projectWise = Project::withCount('changeRequests')->orderByDesc('change_requests_count')->limit(8)->get()
            ->map(fn ($p) => ['name' => $p->name, 'count' => $p->change_requests_count]);

        $developerWorkload = User::where('role', 'developer')->withCount('developedTimelines')
            ->orderByDesc('developed_timelines_count')->limit(8)->get()
            ->map(fn ($d) => ['name' => $d->name, 'count' => $d->developed_timelines_count]);

        return [
            'monthly' => ['labels' => $monthlyLabels, 'values' => $monthlyValues],
            'clients' => ['labels' => $clientWise->pluck('name')->all(), 'values' => $clientWise->pluck('count')->all()],
            'projects' => ['labels' => $projectWise->pluck('name')->all(), 'values' => $projectWise->pluck('count')->all()],
            'developers' => ['labels' => $developerWorkload->pluck('name')->all(), 'values' => $developerWorkload->pluck('count')->all()],
        ];
    }
}
