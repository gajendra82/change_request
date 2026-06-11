<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChangeRequest;
use App\Models\ChangeRequestTimeline;
use App\Models\Client;
use App\Models\Project;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $stats = [
            'by_status' => ChangeRequest::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'by_priority' => ChangeRequest::selectRaw('priority, count(*) as total')->groupBy('priority')->pluck('total', 'priority'),
            'total_revenue' => ChangeRequestTimeline::where('manager_status', 'approved')->sum('cost'),
            'clients' => Client::count(),
            'projects' => Project::count(),
        ];

        return view('admin.reports.index', compact('stats'));
    }
}
