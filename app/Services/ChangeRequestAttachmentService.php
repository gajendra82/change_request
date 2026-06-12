<?php

namespace App\Services;

use App\Models\ChangeRequest;
use App\Models\ChangeRequestAttachment;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ChangeRequestAttachmentService
{
    public const ALLOWED_EXTENSIONS = ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg', 'xls', 'xlsx', 'zip'];

    public const MAX_FILE_SIZE_KB = 10240;

    public const MAX_FILES = 10;

    public function storeMany(ChangeRequest $changeRequest, array $files, User $user): void
    {
        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $this->storeOne($changeRequest, $file, $user);
            }
        }
    }

    public function storeOne(ChangeRequest $changeRequest, UploadedFile $file, User $user): ChangeRequestAttachment
    {
        $path = $file->store('change-requests/'.$changeRequest->id, 'public');

        return ChangeRequestAttachment::create([
            'change_request_id' => $changeRequest->id,
            'uploaded_by' => $user->id,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }

    public function deleteByIds(ChangeRequest $changeRequest, array $ids): void
    {
        $changeRequest->attachments()
            ->whereIn('id', $ids)
            ->get()
            ->each->delete();
    }

    public function deleteAll(ChangeRequest $changeRequest): void
    {
        $changeRequest->attachments()->get()->each->delete();
        Storage::disk('public')->deleteDirectory('change-requests/'.$changeRequest->id);
    }

    public static function validationRules(bool $required = false): array
    {
        $mimes = implode(',', self::ALLOWED_EXTENSIONS);

        return [
            'attachments' => ($required ? 'required' : 'nullable').'|array|max:'.self::MAX_FILES,
            'attachments.*' => 'file|max:'.self::MAX_FILE_SIZE_KB.'|mimes:'.$mimes,
            'remove_attachments' => 'nullable|array',
            'remove_attachments.*' => 'integer|exists:change_request_attachments,id',
        ];
    }
}
