<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeRequest\StoreChangeRequestRequest;
use App\Http\Requests\ChangeRequest\UpdateChangeRequestRequest;
use App\Models\ChangeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChangeRequestController extends Controller
{
    public function index(Request $request): View
    {
        $changeRequests = ChangeRequest::query()
            ->with(['client', 'timeline'])
            ->where('client_id', $request->user()->id)
            ->latest()
            ->get();

        return view('change-requests.index', compact('changeRequests'));
    }

    public function create(): View
    {
        return view('change-requests.create');
    }

    public function store(StoreChangeRequestRequest $request): RedirectResponse
    {
        ChangeRequest::create([
            'client_id' => $request->user()->id,
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
            'priority' => $request->validated('priority'),
            'status' => 'submitted',
        ]);

        return redirect()
            ->route('change-requests.index')
            ->with('success', 'Change request submitted successfully.');
    }

    public function show(Request $request, ChangeRequest $changeRequest): View
    {
        $this->authorizeClientAccess($request, $changeRequest);

        $changeRequest->load(['client', 'timeline.developer', 'timeline.approver']);

        return view('change-requests.show', compact('changeRequest'));
    }

    public function edit(Request $request, ChangeRequest $changeRequest): View
    {
        $this->authorizeClientAccess($request, $changeRequest);

        if ($changeRequest->status !== 'submitted') {
            abort(403, 'Only submitted change requests can be edited.');
        }

        return view('change-requests.edit', compact('changeRequest'));
    }

    public function update(UpdateChangeRequestRequest $request, ChangeRequest $changeRequest): RedirectResponse
    {
        $this->authorizeClientAccess($request, $changeRequest);

        if ($changeRequest->status !== 'submitted') {
            abort(403, 'Only submitted change requests can be edited.');
        }

        $changeRequest->update($request->validated());

        return redirect()
            ->route('change-requests.show', $changeRequest)
            ->with('success', 'Change request updated successfully.');
    }

    public function destroy(Request $request, ChangeRequest $changeRequest): RedirectResponse
    {
        $this->authorizeClientAccess($request, $changeRequest);

        if ($changeRequest->status !== 'submitted') {
            abort(403, 'Only submitted change requests can be deleted.');
        }

        $changeRequest->delete();

        return redirect()
            ->route('change-requests.index')
            ->with('success', 'Change request deleted successfully.');
    }

    private function authorizeClientAccess(Request $request, ChangeRequest $changeRequest): void
    {
        if ($changeRequest->client_id !== $request->user()->id) {
            abort(403, 'Unauthorized access to this change request.');
        }
    }
}
