<?php

namespace App\Http\Controllers;

use App\Models\ChangeRequest;
use App\Models\ChangeRequestAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChangeRequestAttachmentController extends Controller
{
    public function download(Request $request, ChangeRequest $changeRequest, ChangeRequestAttachment $attachment): StreamedResponse
    {
        $this->authorizeAccess($request, $changeRequest, $attachment);

        abort_unless(Storage::disk('public')->exists($attachment->file_path), 404, 'File not found.');

        return Storage::disk('public')->download($attachment->file_path, $attachment->original_name);
    }

    public function destroy(Request $request, ChangeRequest $changeRequest, ChangeRequestAttachment $attachment)
    {
        $this->authorizeAccess($request, $changeRequest, $attachment);

        if ($changeRequest->status !== 'submitted' || ! $request->user()->isClient()) {
            abort(403, 'Attachments can only be removed while the request is in submitted status.');
        }

        $attachment->delete();

        return back()->with('success', 'Attachment removed successfully.');
    }

    private function authorizeAccess(Request $request, ChangeRequest $changeRequest, ChangeRequestAttachment $attachment): void
    {
        if ($attachment->change_request_id !== $changeRequest->id) {
            abort(404);
        }

        $user = $request->user();

        if ($user->isAdmin()) {
            return;
        }

        if ($user->isClient() && $changeRequest->client_id === $user->id) {
            return;
        }

        if ($user->isDeveloper() || $user->isManager()) {
            return;
        }

        abort(403);
    }
}
