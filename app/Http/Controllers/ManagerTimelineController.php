<?php

namespace App\Http\Controllers;

use App\Http\Requests\Timeline\ManagerReviewRequest;
use App\Models\ChangeRequestTimeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ManagerTimelineController extends Controller
{
    public function index(): View
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
            ->get();

        return view('manager.timelines.index', compact('pendingTimelines', 'reviewedTimelines'));
    }

    public function show(ChangeRequestTimeline $timeline): View
    {
        $timeline->load(['changeRequest.client', 'changeRequest.attachments', 'developer', 'approver']);

        return view('manager.timelines.show', compact('timeline'));
    }

    public function approve(ManagerReviewRequest $request, ChangeRequestTimeline $timeline): RedirectResponse
    {
        $this->authorizePendingTimeline($timeline);

        $timeline->update([
            'manager_status' => 'approved',
            'manager_remarks' => $request->validated('manager_remarks'),
            'approved_by' => $request->user()->id,
        ]);

        $timeline->changeRequest->update(['status' => 'approved']);

        return redirect()
            ->route('manager.timelines.index')
            ->with('success', 'Timeline approved successfully.');
    }

    public function reject(ManagerReviewRequest $request, ChangeRequestTimeline $timeline): RedirectResponse
    {
        $this->authorizePendingTimeline($timeline);

        $timeline->update([
            'manager_status' => 'rejected',
            'manager_remarks' => $request->validated('manager_remarks'),
            'approved_by' => $request->user()->id,
        ]);

        $timeline->changeRequest->update(['status' => 'rejected']);

        return redirect()
            ->route('manager.timelines.index')
            ->with('success', 'Timeline rejected successfully.');
    }

    private function authorizePendingTimeline(ChangeRequestTimeline $timeline): void
    {
        if ($timeline->manager_status !== 'pending') {
            abort(403, 'This timeline has already been reviewed.');
        }
    }
}
