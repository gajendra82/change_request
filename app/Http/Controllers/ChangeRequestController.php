<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeRequest\StoreChangeRequestRequest;
use App\Http\Requests\ChangeRequest\UpdateChangeRequestRequest;
use App\Models\ChangeRequest;
use App\Services\ChangeRequestAttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChangeRequestController extends Controller
{
    public function __construct(
        private ChangeRequestAttachmentService $attachmentService,
    ) {}

    public function index(Request $request): View
    {
        $changeRequests = ChangeRequest::query()
            ->with(['client', 'timeline', 'attachments'])
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
        $changeRequest = ChangeRequest::create([
            'client_id' => $request->user()->id,
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
            'priority' => $request->validated('priority'),
            'status' => 'submitted',
        ]);

        if ($request->hasFile('attachments')) {
            $this->attachmentService->storeMany(
                $changeRequest,
                $request->file('attachments'),
                $request->user()
            );
        }

        return redirect()
            ->route('change-requests.index')
            ->with('success', 'Change request submitted successfully.');
    }

    public function show(Request $request, ChangeRequest $changeRequest): View
    {
        $this->authorizeClientAccess($request, $changeRequest);

        $changeRequest->load(['client', 'timeline.developer', 'timeline.approver', 'attachments.uploader']);

        return view('change-requests.show', compact('changeRequest'));
    }

    public function edit(Request $request, ChangeRequest $changeRequest): View
    {
        $this->authorizeClientAccess($request, $changeRequest);

        if ($changeRequest->status !== 'submitted') {
            abort(403, 'Only submitted change requests can be edited.');
        }

        $changeRequest->load('attachments');

        return view('change-requests.edit', compact('changeRequest'));
    }

    public function update(UpdateChangeRequestRequest $request, ChangeRequest $changeRequest): RedirectResponse
    {
        $this->authorizeClientAccess($request, $changeRequest);

        if ($changeRequest->status !== 'submitted') {
            abort(403, 'Only submitted change requests can be edited.');
        }

        $changeRequest->update($request->safe()->only(['title', 'description', 'priority']));

        if ($request->filled('remove_attachments')) {
            $this->attachmentService->deleteByIds($changeRequest, $request->input('remove_attachments'));
        }

        if ($request->hasFile('attachments')) {
            $this->attachmentService->storeMany(
                $changeRequest,
                $request->file('attachments'),
                $request->user()
            );
        }

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

        $this->attachmentService->deleteAll($changeRequest);
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
