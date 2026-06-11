<?php

namespace App\Http\Controllers;

use App\Models\ChangeRequest;
use App\Models\ChangeRequestTimeline;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isClient()) {
            return $this->clientDashboard($user);
        }

        if ($user->isDeveloper()) {
            return $this->developerDashboard($user);
        }

        if ($user->isManager()) {
            return $this->managerDashboard();
        }

        abort(403, 'Invalid user role.');
    }

    private function clientDashboard($user): View
    {
        $query = ChangeRequest::query()
            ->with('timeline')
            ->where('client_id', $user->id);

        $changeRequests = (clone $query)->latest()->get();

        $stats = $this->buildStats($changeRequests);
        $chartData = $this->buildChartData($query);

        return view('dashboards.client', compact('changeRequests', 'stats', 'chartData', 'user'));
    }

    private function developerDashboard($user): View
    {
        $pendingRequests = ChangeRequest::query()
            ->with('client')
            ->where('status', 'submitted')
            ->latest()
            ->get();

        $timelinesAdded = ChangeRequestTimeline::query()
            ->with(['changeRequest.client'])
            ->where('developer_id', $user->id)
            ->latest()
            ->get();

        $crQuery = ChangeRequest::query()->whereIn('id', $timelinesAdded->pluck('change_request_id'));

        $stats = [
            'total' => $timelinesAdded->count() + $pendingRequests->count(),
            'pending_timelines' => $pendingRequests->count(),
            'approved' => $timelinesAdded->where('manager_status', 'approved')->count(),
            'rejected' => $timelinesAdded->where('manager_status', 'rejected')->count(),
            'completed' => ChangeRequest::whereIn('id', $timelinesAdded->pluck('change_request_id'))->where('status', 'completed')->count(),
            'total_revenue' => $timelinesAdded->where('manager_status', 'approved')->sum('cost'),
            'submitted' => $pendingRequests->count(),
        ];

        $chartData = $this->buildChartData(ChangeRequest::query());

        return view('dashboards.developer', compact('pendingRequests', 'timelinesAdded', 'stats', 'chartData', 'user'));
    }

    private function managerDashboard(): View
    {
        $pendingTimelines = ChangeRequestTimeline::query()
            ->with(['changeRequest.client', 'developer'])
            ->where('manager_status', 'pending')
            ->latest()
            ->get();

        $reviewedTimelines = ChangeRequestTimeline::query()
            ->with(['changeRequest.client', 'developer', 'approver'])
            ->whereIn('manager_status', ['approved', 'rejected'])
            ->latest()
            ->limit(10)
            ->get();

        $allTimelines = ChangeRequestTimeline::query()->get();

        $stats = [
            'total' => ChangeRequest::count(),
            'pending_timelines' => $pendingTimelines->count(),
            'approved' => ChangeRequestTimeline::where('manager_status', 'approved')->count(),
            'rejected' => ChangeRequestTimeline::where('manager_status', 'rejected')->count(),
            'completed' => ChangeRequest::where('status', 'completed')->count(),
            'total_revenue' => ChangeRequestTimeline::where('manager_status', 'approved')->sum('cost'),
            'submitted' => ChangeRequest::where('status', 'submitted')->count(),
        ];

        $chartData = $this->buildChartData(ChangeRequest::query());

        return view('dashboards.manager', compact('pendingTimelines', 'reviewedTimelines', 'stats', 'chartData'));
    }

    private function buildStats($changeRequests): array
    {
        return [
            'total' => $changeRequests->count(),
            'pending_timelines' => $changeRequests->where('status', 'timeline_added')->count(),
            'approved' => $changeRequests->where('status', 'approved')->count(),
            'rejected' => $changeRequests->where('status', 'rejected')->count(),
            'completed' => $changeRequests->where('status', 'completed')->count(),
            'total_revenue' => $changeRequests
                ->filter(fn ($cr) => $cr->timeline && $cr->timeline->manager_status === 'approved')
                ->sum(fn ($cr) => $cr->timeline->cost),
            'submitted' => $changeRequests->where('status', 'submitted')->count(),
        ];
    }

    private function buildChartData(Builder $query): array
    {
        $requests = (clone $query)->with('timeline')->get();

        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i));
        }

        $monthlyLabels = $months->map(fn ($m) => $m->format('M Y'))->values()->all();
        $monthlyValues = $months->map(function ($m) use ($requests) {
            return $requests->filter(fn ($cr) => $cr->created_at->isSameMonth($m))->count();
        })->values()->all();

        $statusMap = [
            'Submitted' => $requests->where('status', 'submitted')->count(),
            'Timeline Added' => $requests->where('status', 'timeline_added')->count(),
            'Approved' => $requests->where('status', 'approved')->count(),
            'Rejected' => $requests->where('status', 'rejected')->count(),
            'Completed' => $requests->where('status', 'completed')->count(),
        ];

        $statusLabels = array_keys(array_filter($statusMap, fn ($v) => $v > 0));
        $statusValues = array_values(array_filter($statusMap, fn ($v) => $v > 0));

        if (empty($statusLabels)) {
            $statusLabels = ['No Data'];
            $statusValues = [0];
        }

        $revenueLabels = $monthlyLabels;
        $revenueValues = $months->map(function ($m) use ($requests) {
            return (int) $requests
                ->filter(fn ($cr) => $cr->timeline
                    && $cr->timeline->manager_status === 'approved'
                    && $cr->created_at->isSameMonth($m))
                ->sum(fn ($cr) => $cr->timeline->cost);
        })->values()->all();

        return [
            'monthly' => ['labels' => $monthlyLabels, 'values' => $monthlyValues],
            'status' => ['labels' => $statusLabels, 'values' => $statusValues],
            'revenue' => ['labels' => $revenueLabels, 'values' => $revenueValues],
        ];
    }
}
