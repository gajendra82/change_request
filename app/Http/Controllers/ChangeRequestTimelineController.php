<?php

namespace App\Http\Controllers;

use App\Http\Requests\Timeline\StoreTimelineRequest;
use App\Http\Requests\Timeline\UpdateTimelineRequest;
use App\Models\ChangeRequest;
use App\Models\ChangeRequestTimeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ChangeRequestTimelineController extends Controller
{
    public function index(): View
    {
        $pendingRequests = ChangeRequest::query()
            ->with('client')
            ->where('status', 'submitted')
            ->latest()
            ->get();

        $timelines = ChangeRequestTimeline::query()
            ->with(['changeRequest.client'])
            ->where('developer_id', auth()->id())
            ->latest()
            ->get();

        return view('timelines.index', compact('pendingRequests', 'timelines'));
    }

    public function create(ChangeRequest $changeRequest): View|RedirectResponse
    {
        $this->authorizePendingRequest($changeRequest);
        $changeRequest->load(['client', 'attachments']);

        if ($changeRequest->timeline) {
            return redirect()
                ->route('timelines.edit', $changeRequest->timeline)
                ->with('info', 'Timeline already exists. You can edit it below.');
        }

        return view('timelines.create', compact('changeRequest'));
    }

    public function store(StoreTimelineRequest $request, ChangeRequest $changeRequest): RedirectResponse
    {
        $this->authorizePendingRequest($changeRequest);

        if ($changeRequest->timeline) {
            return redirect()
                ->route('timelines.edit', $changeRequest->timeline)
                ->with('error', 'Timeline already exists for this change request.');
        }

        $estimatedDays = $request->validated('estimated_days');

        ChangeRequestTimeline::create([
            'change_request_id' => $changeRequest->id,
            'developer_id' => $request->user()->id,
            'estimated_days' => $estimatedDays,
            'cost' => ChangeRequestTimeline::calculateCost($estimatedDays),
            'start_date' => $request->validated('start_date'),
            'end_date' => $request->validated('end_date'),
            'remarks' => $request->validated('remarks'),
            'manager_status' => 'pending',
        ]);

        $changeRequest->update(['status' => 'timeline_added']);

        return redirect()
            ->route('timelines.index')
            ->with('success', 'Timeline added successfully. Awaiting manager review.');
    }

    public function edit(ChangeRequestTimeline $timeline): View
    {
        $this->authorizeEditableTimeline($timeline);

        $timeline->load('changeRequest.client');

        return view('timelines.edit', compact('timeline'));
    }

    public function update(UpdateTimelineRequest $request, ChangeRequestTimeline $timeline): RedirectResponse
    {
        $this->authorizeEditableTimeline($timeline);

        $estimatedDays = $request->validated('estimated_days');

        $timeline->update([
            'estimated_days' => $estimatedDays,
            'cost' => ChangeRequestTimeline::calculateCost($estimatedDays),
            'start_date' => $request->validated('start_date'),
            'end_date' => $request->validated('end_date'),
            'remarks' => $request->validated('remarks'),
        ]);

        return redirect()
            ->route('timelines.index')
            ->with('success', 'Timeline updated successfully.');
    }

    private function authorizePendingRequest(ChangeRequest $changeRequest): void
    {
        if ($changeRequest->status !== 'submitted') {
            abort(403, 'Timeline can only be added to submitted change requests.');
        }
    }

    private function authorizeEditableTimeline(ChangeRequestTimeline $timeline): void
    {
        if ($timeline->developer_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this timeline.');
        }

        if ($timeline->manager_status !== 'pending') {
            abort(403, 'Timeline cannot be edited after manager review.');
        }
    }
}
